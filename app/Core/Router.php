<?php 

namespace App\Core;

use App\Core\Route\Route;
use App\Core\Route\Exception\NotFoundException;
use App\Core\Controller\ControllerResolver;

class Router 
{

    /**
     * List of routes
     * @var array
     */
    protected $routes = array();

    /**
     * List of named routes
     * @var array
     */
    protected $namedRoutes = array();

    /**
     * List of HTTP verbs
     * @var array
     */
    protected $verbs = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE');
    
    /**
     * List of RESTful action
     * @var array
     */
    protected $actions = array(
        'index' => array('verb' => 'get', 'url' => ''),
        'create' => array('verb' => 'get', 'url' => '/create'),
        'store' => array('verb' => 'post', 'url' => ''),
        'edit' => array('verb' => 'get', 'url' => '/:id'),
        'update' => array('verb' => 'put', 'url' => '/:id'),
        'delete' => array('verb' => 'delete', 'url' => '/:id')
    );

    public function __construct(ControllerResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Register a new route
     * @param  string $method Name of the HTTP method
     * @param  array $args    List of the arguments for the route
     * @return Route $route   Route created
     */
    public function __call($method, $args)
    {
        $method = strtoupper($method);
        if (in_array($method, $this->verbs)) {
            $route = new Route($args[0], $args[1], $this->resolver);
            $this->routes[$method][] = $route;
            if (isset($args[2])) {
                $this->namedRoutes[$args[2]] = $route;
            }
            return $route;
        }
    }

    /**
     * Register RESTful route associated to a resource
     * @param  string $name       Name of the resource
     * @param  string $controller Controller associated to the resource
     * @param  array  $options    Options for the routes
     */
    public function resource($name, $controller = null, $options = array())
    {
        if (!$controller) {
            $controller = ucfirst($name) . 'Controller';
        }
        
        foreach($this->actions as $actionName=>$action) {
            if (!(array_key_exists('only', $options) && !in_array($actionName, $options['only'])) && 
                !(array_key_exists('except', $options) && in_array($actionName, $options['except']))) {
                $this->$action['verb']($name . $action['url'], $controller . '@' . $actionName, "$name.$actionName");        
            }
        }
    }
    /**
     * Register a new route responding to all verbs
     * @param  string $path     Path of the route
     * @param         $action   Action (Callable or 'Controller@method')
     * @param  string $name     Name of the route
     */
    public function any($path, $action, $name = null)
    {
        foreach($this->verbs as $verb) {
            $this->$verb($path, $action, $name);
        }
    }

    /**
     * Call the action associated to the url
     */
    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            if (array_key_exists('_method', $_POST) && in_array($_POST['_method'], ['GET', 'PUT', 'DELETE'])) {
                $method = $_POST['_method'];
            }
        }

        $url = substr($_SERVER['REQUEST_URI'], strlen(WEBROOT));
        if (strpos($url, '?') !== false) {
            $url = strstr($url, '?', true);
        }

        foreach ($this->routes[$method] as $route) {
            if ($route->match($url)) {
                return $route->call();
            }
        }
       
        throw new NotFoundException(); // when no route matches the URL
    }

    /**
     * Return the url from a named route
     * @param  string $name   Name of the routes
     * @param  array  $params List of the params for the route
     * @return string         Url of the route
     */
    public function url($name, $params = array())
    {
        if (!array_key_exists($name, $this->namedRoutes)) {
            return '';
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}

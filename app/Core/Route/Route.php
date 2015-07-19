<?php 

namespace App\Core\Route;

class Route
{

    /**
     * Path of the route
     * @var [type]
     */
    protected $path;

    /**
     * Action associated to the route
     * @var [type]
     */
    protected $action;

    /**
     * List of params for the action 
     * @var array
     */
    protected $params = array();

    /**
     * Regular expression for the params
     * @var array
     */
    protected $paramsRegex = array();

    /**
     * Constructor
     * @param string $path   Path of the route
     * @param        $action Action associated (Callable or 'Controller@method')
     */
    public function __construct($path, $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    /**
     * Call the action associated to the route
     */
    public function call()
    {
        if(is_callable($this->action)) 
        {
            return call_user_func_array($this->action, $this->params);
        }
        else if(is_string($this->action) && strpos($this->action, '@'))
        {
            $name = explode('@', $this->action);
            $controller = App::get('Controllers\\' . $name[0]);
            return call_user_func_array([$controller, $name[1]], $this->params);
        }
        else
        {
            $controller = App::get('Core\Controller');
            /**
             * @todo internal error : action not callable
             */
            return $controller->notFound(); 
        }
    }

    /**
     * Check if the url match the route
     * @param  string $url Url to check
     * @return bool
     */
    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches))
        {
            return false;
        }
        array_shift($matches);
        $this->params = $matches;
        return true;
    }

    /**
     * Callback to get the regular expression for each params
     * @param  string $match Params matched by preg_replace
     * @return string        Regular expression
     */
    protected function paramMatch($match)
    {
        if(isset($this->paramsRegex[$match[1]]))
        {
            return '(' . $this->paramsRegex[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * Add a custom regular expression to a param
     * @param  string $param Name of the param
     * @param  string $regex Regular expression
     * @return Route $this
     */
    public function with($param, $regex)
    {
        $this->paramsRegex[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    /**
     * Get the url of the route with the given params
     * @param  array  $params Params for the url
     * @return string
     */
    public function getUrl($params)
    {
        $path = $this->path;
        foreach ($params as $k => $v) 
        {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

}
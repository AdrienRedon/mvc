<?php 

namespace Core;

use \Core\Controller;

class Bootstrap
{
    protected $routes;
    
    protected $controller;
    protected $method;
    protected $params;

    public function __construct()
    {
        $this->routes = Router::getInstance();

        $config = Config::getInstance();
        $this->controller = $config->get('default_controller');
        $this->method     = $config->get('default_method');
        $this->params     = $config->get('default_args');

        $url = array();


        if($this->isCustomRoute()) 
        {
            $url[0] = $this->routes->getController($_GET['url']);
            $url[1] = $this->routes->getMethod($_GET['url']);
            $url = array_merge($url, explode('/', substr_replace($_GET['url'], '', 0, strlen(implode('/', $url)) + 1)));
        }
        else
        {
            $url = $this->parseUrl();
        }
        
        $this->controller = $url[0] . 'Controller';

        $controller = '\Controllers\\' . $this->controller;

        $this->controller = new $controller;

        unset($url[0]);

        if(isset($url[1]))
        {
            if(method_exists($this->controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
            else
            {
                $this->errors();
            }
        }

        $this->params = $url ? array_values($url) : [];


        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Split the controller, the method and the args from the url
     * @return $url array Array with the controller, the method and the args
     */
    private function parseUrl()
    {
        if(isset($_GET['url']))
        {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        else 
        {
            return $url = [
                $this->controller,
                $this->method,
                $this->params
            ];
        }
    }

    /**
     * Check if the url is a custom route in the config folder
     * @return boolean [description]
     */
    private function isCustomRoute()
    {
        if(isset($_GET['url']))
        {
            if($this->routes->get($_GET['url']))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Call the method for 404
     */
    private function errors()
    {
        $this->controller = new Controller;
        $this->controller->notFound();
        exit;
    }
}

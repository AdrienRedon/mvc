<?php 

namespace Core;

class Router
{

    private $routes = array();

    public function __construct()
    {
        $this->routes = require (ROOT . '/config/routes.php');
    }

    public function get($key)
    {
        if(array_key_exists($key, $this->routes))
        {
            return $this->routes[$key];
        }
        else
        {
            return $this->_findWithoutArgs($key);
        }
    }

    public function getController($key)
    {
        if($this->get($key))
        {
            return $this->get($key)[0];
        }
        else
        {
            return null;
        }
    }

    public function getMethod($key)
    {
        if($this->get($key))
        {
            return $this->get($key)[1];
        }
        else
        {
            return null;
        }
    }

    private function _findWithoutArgs($key)
    {
        $next_key = substr_replace($key, '', strrpos($key, '/'));

        if(strlen($next_key) > 0)
        {
            return $this->get($next_key);
        }
        else 
        {
            return null;
        }
    }

}

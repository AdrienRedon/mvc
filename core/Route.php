<?php 

namespace Core;

use Core\Controller;

/**
 * Get the route
 */
require_once(ROOT . 'routes.php');

class Route 
{
    protected static $routes;

    public static function __callStatic($method, $args)
    {
        SELF::$routes[$method][$args[0]] = $args[1];
    }

    public static function resource($name, $controller = null, $options = array())
    {
        if (!$controller)
        {
            $controller = ucfirst($name) . 'Controller';
        }

        if(!(array_key_exists('only', $options) && !in_array('index', $options['only'])) && 
            !(array_key_exists('except', $options) && in_array('index', $options['except'])))
        {
           SELF::get($name, $controller . '@index');        
        }

        if(!(array_key_exists('only', $options) && !in_array('create', $options['only'])) && 
            !(array_key_exists('except', $options) && in_array('create', $options['except'])))
        {
            SELF::get($name . '/create', $controller . '@create');
        }

        if(!(array_key_exists('only', $options) && !in_array('store', $options['only'])) && 
            !(array_key_exists('except', $options) && in_array('store', $options['except'])))
        {
            SELF::post($name, $controller . '@store');
        }

        if(!(array_key_exists('only', $options) && !in_array('show', $options['only'])) && 
            !(array_key_exists('except', $options) && in_array('show', $options['except']))) 
        {
            SELF::get($name . '/{id}', $controller . '@show');
        }

        if(!(array_key_exists('only', $options) && !in_array('edit', $options['only'])) && 
            !(array_key_exists('except', $options) && in_array('edit', $options['except'])))
        {
            SELF::get($name . '/{id}/edit', $controller . '@edit');
        }

        if(!(array_key_exists('only', $options) && !in_array('update', $options['only'])) && 
            !(array_key_exists('except', $options) && in_array('update', $options['except'])))
        {
            SELF::put($name . '/{id}', $controller . '@update');
        }

        if(!(array_key_exists('only', $options) && !in_array('delete', $options['only'])) && 
            !(array_key_exists('except', $options) && in_array('delete', $options['except'])))
        {
            SELF::delete($name . '/{id}', $controller . '@delete');
        }
    }

    public static function bootstrap()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'POST')
        {
            if(array_key_exists('_method', $_POST) && in_array($_POST['_method'], ['GET', 'PUT', 'DELETE']))
            {
                $method = $_POST['_method'];
            }
        }

        foreach (SELF::$routes[strtolower($method)] as $route => $action) 
        {
            $url = substr($_SERVER['REQUEST_URI'], strlen(WEBROOT));

            if(!$url) 
            {
                $url = '/';
            }

            $isRoute = false;

            $routeParam = explode('/', $route);

            if($routeParam[count($routeParam) - 1] == '') 
            {
                unset($routeParam[count($routeParam) - 1]);
            }

            $urlParam = explode('/', $url);

            if($urlParam[count($urlParam) - 1] == '') 
            {
                unset($urlParam[count($urlParam) - 1]);
            }

            if(count($routeParam) == count($urlParam))
            {
                $isRoute = true;
                $params = array();

                foreach($urlParam as $k => $param)
                {
                    if(preg_match("@\{(\w+)}@", $routeParam[$k])) 
                    {
                        $params[substr($routeParam[$k], 1, count($routeParam[$k]) - 2)] = $urlParam[$k];
                    }
                    else if(!preg_match("@{$routeParam[$k]}@i", $param, $p)) 
                    {
                        $isRoute = false;
                    }
                } 

                if($routeParam[0] == '' && $urlParam[0] != '') 
                {
                    $isRoute = false;
                }

                if($isRoute) {

                    if(is_callable($action))
                    {
                        return call_user_func_array($action, $params);
                    }

                    if(is_string($action) && strpos($action, '@') !== false)
                    {
                        $name = explode('@', $action);
                        $controller = App::get('Controllers\\' . $name[0]);
                        return call_user_func_array(array($controller, $name[1]), $params);
                    }

                }
            }

        }
       
        $controller = App::get('Core\Controller');
        return $controller->notFound();
    }
}
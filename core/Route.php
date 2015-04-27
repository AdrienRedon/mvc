<?php 

namespace Core;

use Core\Controller;

class Route 
{
    protected static $routes;

    public static function __callStatic($method, $args)
    {
        SELF::$routes[$method][$args[0]] = $args[1];
    }

    public static function bootstrap()
    {
        foreach (SELF::$routes[strtolower($_SERVER['REQUEST_METHOD'])] as $route => $action) 
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
                        return $action(extract($params));
                    }

                    if(is_string($action) && strpos($action, '@') !== false)
                    {
                        $name = explode('@', $action);
                        $controller = App::get('Controllers\\' . $name[0]);
                        return $controller->$name[1](extract($params));
                    }

                }
            }

        }
       
        $controller = App::get('Core\Controller');
        return $controller->notFound();
    }
}
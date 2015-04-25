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

            if(preg_match("@$route@i", $url, $p, PREG_OFFSET_CAPTURE))
            {
                if($p[0][1] ===  0) {
                    
                    if(is_callable($action))
                    {
                        return $action();
                    }

                    if(is_string($action) && strpos($action, '@') !== false)
                    {
                        $name = explode('@', $action);
                        $controller = App::get('Controllers\\' . $name[0]);
                        return $controller->$name[1]($p);
                    }

                }
            }
        }
       
        $controller = App::get('Core\Controller');
        return $controller->notFound();
    }
}
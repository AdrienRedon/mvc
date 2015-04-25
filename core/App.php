<?php

namespace Core;

use \Core\Config;

class App
{
    /**
     * Call method from the Dependency Injection Container 
     */
    public static function __callStatic($method, $args = array())
    {
        return call_user_func_array(array(DIC::getInstance(), $method), $args);
    }

    /**
     * Associate all implementation classes to interfaces in the DIC as written in the config files
     */
    public static function register()
    {
        $providers = SELF::get('Core\Config')->get('providers');

        foreach($providers as $interface => $class)
        {
            SELF::bind($interface, $class);
        }
    }
}
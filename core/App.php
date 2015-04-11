<?php

namespace Core;

use \Core\Config;

class App
{
    public static function __callStatic($method, $args = array())
    {
        return call_user_func_array(array(DIC::getInstance(), $method), $args);
    }

    public static function register()
    {
        $providers = Config::getInstance()->get('providers');
        foreach($providers as $interface => $class)
        {
            SELF::bind($interface, $class);
        }
    }
}
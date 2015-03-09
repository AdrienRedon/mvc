<?php

namespace Controllers;

class Autoloader
{

    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    protected static function autoload($class)
    {
        if (strpos($class, __NAMESPACE__ . '\\') === 0){
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            require __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
        }
    }

}
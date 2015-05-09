<?php 

class Autoloader
{
    /**
     * Register autoload method as autoloader
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Autoload a class
     * @param  string $class Name of the class
     */
    protected static function autoload($class)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        require __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
    }

}
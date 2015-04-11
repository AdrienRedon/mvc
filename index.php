<?php 
/**
 * PHP MVC Framework v0.1
 * By Adrien REDON (@AdrienRedon)
 */

/**
 * Function for debugging
 */
function dd() 
{
    foreach(func_get_args() as $var)
    {
        var_dump($var);
    }
    die();
}

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

// Autoload for the librairies
require_once(ROOT . 'libs/Autoloader.php');
\Libs\Autoloader::register();

// Autoload for the core
require_once(ROOT . 'core/Autoloader.php');
\Core\Autoloader::register();

// Autoload for the models
require_once(ROOT . 'models/Autoloader.php');
\Models\Autoloader::register();

// Autoload for the controllers
require_once(ROOT . 'controllers/Autoloader.php');
\Controllers\Autoloader::register();

/**
 * Service Provider
 */
\Core\App::register();

/**
 * Find controller and method to call
 */
$bootstrap = new \Core\Bootstrap();
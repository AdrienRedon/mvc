<?php 
/**
 * PHP MVC Framework v0.1
 * By Adrien REDON (@AdrienRedon)
 */

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

require_once('Autoloader.php');

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

/**
 * Autoloader
 */
Autoloader::register();

/**
 * Service Provider
 */
\Core\App::register();

/**
 * Find controller and method to call
 */
\Core\Route::bootstrap();
<?php 
/**
 * PHP MVC Framework v0.1
 * By Adrien REDON (@AdrienRedon)
 */

require_once(ROOT . 'Autoloader.php');

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
\Core\App::get('Core\Bootstrap');

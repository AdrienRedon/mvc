<?php 
/**
 * PHP MVC Framework v0.1
 * By Adrien REDON (@AdrienRedon)
 */

function dd($var) 
{
	die(var_dump($var));
}

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

// Autoload for the librairies
require_once(ROOT . 'libs/Autoloader.php');
\Libs\Autoloader::register();

// Autoload for the core
require_once(ROOT . 'core/Autoloader.php');
\Core\Autoloader::register();



$app = new \Core\Bootstrap();
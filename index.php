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

// Autoload for the controllers
require_once(ROOT . 'controllers/Autoloader.php');
\Controllers\Autoloader::register();

$app = \Core\DIC::getInstance();

$app->set('Database', function() {
    $host = \Core\Config::getInstance()->get('sql_host');
    $base = \Core\Config::getInstance()->get('sql_base');
    $login = \Core\Config::getInstance()->get('sql_login');
    $password = \Core\Config::getInstance()->get('sql_password');
    return new \Core\Database($host, $base, $login, $password);
});

$app->set('Session', function() {
    return new \Libs\Session();
});

$app->set('Flash', function() use ($app) {
    return new \Libs\Flash($app->get('Session'));
});

$app->set('Html', function() use ($app) {
    return new \Libs\Html();
});

$app->set('Asset', function() use ($app) {
    return new \Libs\Asset();
});

$app->set('Form', function() use ($app) {
    return new \Libs\Form($app->get('Session'));
});

$bootstrap = new \Core\Bootstrap();
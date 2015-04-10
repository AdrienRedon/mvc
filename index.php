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

$app->set('\Core\Controller', function() use ($app) {
    return new \Core\Controller($app->get('\Core\View'), $app->get('\Libs\Auth'), $app->get('\Libs\Redirect'), $app->get('\Libs\Flash'));
});

$app->set('\Core\Database', function() {
    $config = \Core\Config::getInstance();
    $host = $config->get('sql_host');
    $base = $config->get('sql_base');
    $login = $config->get('sql_login');
    $password = $config->get('sql_password');
    return new \Core\Database($host, $base, $login, $password);
});

$app->set('\Core\View', function() use ($app) {
    return new \Core\View($app->get('\Libs\Flash'), $app->get('\Libs\Html'), $app->get('\Libs\Asset'), $app->get('\Libs\Form'));
});

$app->set('\Libs\Flash', function() use ($app) {
    return new \Libs\Flash($app->get('\Libs\Session'));
});

$app->set('\Libs\Form', function() use ($app) {
    return new \Libs\Form($app->get('\Libs\Session'));
});

$app->set('\Libs\Auth', function() use ($app) {
    return new \Libs\Auth($app->get('\Libs\Session'));
});

$app->set('\Libs\Redirect', function() use ($app) {
    return new \Libs\Redirect($app->get('\Libs\Session'));
});

$app->set('\Libs\Mail', function() {
    $config = \Core\Config::getInstance();
    $email = $congig->get('email');
    return new \Libs\Mail($email);
});

$bootstrap = new \Core\Bootstrap();
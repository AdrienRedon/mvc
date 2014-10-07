<?php 
/**
 * PHP MVC Framework v0.1
 * By Adrien REDON (@AdrienRedon)
 */

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

require_once(ROOT . 'core/config.php');
require_once(ROOT . 'libs/autoload.php');

require_once(ROOT . 'core/model.php');
require_once(ROOT . 'core/view.php');
require_once(ROOT . 'core/controller.php');

require_once(ROOT . 'core/bootstrap.php');

$app = new Bootstrap();
<?php 

define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('/public', '', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME'])));

date_default_timezone_set('Europe/Paris');

include('bootstrap.php');

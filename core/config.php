<?php 

/**
 * Configuration de la base de données MySQL
 */
define('SQL_HOST', 'localhost');
define('SQL_BASE', 'mvc');
define('SQL_LOGIN', 'root');
define('SQL_PASS', '');

/**
 * Configuration du controller et de la méthode à appeller par défaut
 */
define('DEFAULT_CONTROLLER', 'pages');
define('DEFAULT_METHOD', 'index');
define('DEFAULT_ARGS', null); // Unique argument car 'define' n'accepte pas de tableau

/**
 * Configuration des vues
 */
define('DEFAULT_LAYOUT', 'layout');
define('DEFAULT_TITLE', 'MVC');

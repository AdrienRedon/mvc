<?php

return [

	/**
	 * Mode debug
	 */
	'debug' => true,

	/**
	 * Configuration de la base de données SQL
	 */
	'sql_host' => 'localhost',
	'sql_base' => 'mvc',
	'sql_login' => 'root',
	'sql_password' => '',

	/**
	 * Configuration du controller et de la méthode à appeler par défaut
	 */
	'default_controller' => 'page',
	'default_method' => 'index',
	'default_args' => null,

	/**
	 * Configuration des vues
	 */
	'default_layout' => 'default',
	'default_title' => 'MVC',

	/**
	 * Configuration de l'adresse Mail
	 */
	'email' => 'no-reply@mvc.com',


	/**
	 * Service Providers
	 */
	'providers' => array(
		'Libs\Interfaces\DatabaseInterface' => 'Libs\MySQLDatabase',
		'Libs\Interfaces\SessionInterface'  => 'Libs\Session',
		'Libs\Interfaces\MailerInterface'   => 'Libs\Mail',
	),
];

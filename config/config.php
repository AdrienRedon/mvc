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
	 * Home route
	 */
	'home_route' => '',

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

<?php 

require_once(ROOT . 'libs/interfaces/session_interface.php');

class Session implements SessionInterface
{
	public function __construct()
	{
		if(!isset($_SESSION))
		{
			session_start();
		}
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

	public function destroy($key)
	{
		unset($_SESSION[$key]);
	}
}
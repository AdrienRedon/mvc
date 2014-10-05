<?php 

require_once(ROOT . 'libs/auth.php');

class Controller
{
	public function __construct()
	{
		$this->view = new View();
		$this->auth = new Auth();

		if(isset($_POST))
		{
			$this->data = $_POST;
		}
	}

	/**
	 * Determine si l'appel a été fait en Ajax
	 * @return bool
	 */
	public function isAjax()
	{
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
}
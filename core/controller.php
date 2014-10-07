<?php 

class Controller
{
	protected $session;
	protected $view;
	protected $auth;
	protected $redirect;
	protected $flash;

	/**
	 * Données passées en POST
	 * @var Array
	 */
	protected $data;

	public function __construct()
	{
		$this->session = new Session;

		$this->view = new View;
		$this->auth = new Auth($this->session);
		$this->redirect = new Redirect($this->session);
		$this->flash = new Flash($this->session);

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
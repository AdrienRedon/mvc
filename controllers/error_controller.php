<?php 

class ErrorController extends \Core\Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function _404()
	{
		if($this->isAjax())
		{
			$this->view->json('Page introuvable', 404);
		}
		else
		{
			$this->view->render('errors/404');
		}
	}

	public function _500()
	{
		if($this->isAjax())
		{
			$this->view->json('Erreur interne', 500);
		}
		else
		{
			$this->view->render('errors/500');
		}
	}
}
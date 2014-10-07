<?php

class Sessions extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		if(isset($this->data['login'], $this->data['password']))
		{
			$logged = $this->auth->attempt($this->data['login'], $this->data['password']);
		}
		else
		{
			$logged = false;
		}

		if($this->isAjax())
		{
			if($logged)
			{
				$user = $this->auth->user();
				$this->view->json(compact('logged', 'user'));
			}
			else
			{
				$this->view->json(compact('logged', 500));
			}
		}
		else
		{
			if($logged)
			{
				$this->flash->set('Vous êtes bien connecté');
			}
			else
			{
				$this->flash->set('Les identifiants sont incorrects');
			}

			$this->redirect->back();
		}
	}

	public function logout()
	{
		$this->auth->logout();
		
		if($this->isAjax())
		{
			$this->view->json(['logged_out' => true]);
		}
		else
		{
			$this->flash->set('Vous êtes bien déconnecté');
			$this->redirect->home();
		}
	}

}
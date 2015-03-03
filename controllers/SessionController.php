<?php

use \Libs\Validation;

class SessionController extends \Core\Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		$input = [
			'login'            => $this->data['login'], 
			'password'         => $this->data['password'],
			'password_confirm' => $this->data['password_confirm']
		];

		$rules = [
			'login'    => 'required|min:3',
			'password' => 'required|confirmed'
		];

		$this->validation = new Validation($input, $rules);

		if($this->validation->passes())
		{
			$logged = $this->auth->attempt($input['login'], $input['password']);

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
					$this->redirect->home();
				}
				else
				{
					$this->flash->set('Les identifiants sont incorrects');
					$this->redirect->backWithInput($input);
				}

			}

		}
		else
		{
			$logged = false;

			if($this->isAjax())
			{
				$this->view->json(compact('logged'), 500);
			}
			else
			{
				$this->flash->set($this->validation->getErrors());
				$this->redirect->backWithInput($input);
			}
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

<?php

namespace Libs;

class Redirect
{
	protected $session;
	
	public function __construct(\Libs\interfaces\SessionInterface $session)
	{
		$this->session = $session;
	}
	
	public function back()
	{
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	
	public function backWithInput($input)
	{
		$this->session->set('input', $input);
		$this->back();
	}

	public function to($url)
	{
		header('Location: ' . WEBROOT. $url);
	}

	public function home()
	{
		$this->to(DEFAULT_CONTROLLER . '/' . DEFAULT_METHOD);
	}
}

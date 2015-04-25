<?php

namespace Libs;

use \Core\App;
use \Core\Config;
use \Libs\interfaces\SessionInterface;

class Redirect
{
	protected $session;
	
	public function __construct(SessionInterface $session)
	{
		$this->session = $session;
	}
	
	public function back()
	{
		if(array_key_exists('HTTP_REFERER', $_SERVER))
		{
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		else
		{
			$this->home();
		}
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
		$config = App::get('Core\Config');
		$this->to($config->get('home_route'));
	}
}

<?php

class Redirect
{
	public function back()
	{
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	public function to($url)
	{
		header('Location: ' . $url);
	}

	public function home()
	{
		$this->to(WEBROOT . DEFAULT_CONTROLLER . '/' . DEFAULT_METHOD);
	}
}
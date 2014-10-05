<?php 

class Session
{
	protected $name;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function set($value)
	{
		$_SESSION[$this->name] = $value;
	}

	public function get()
	{
		return isset($_SESSION[$this->name]) ? $_SESSION[$this->name] : null;
	}

	public function destroy()
	{
		unset($_SESSION[$this->name]);
	}
}
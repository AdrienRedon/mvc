<?php

class User extends \Core\Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = "users";
		$this->hidden = ['password'];
	}


}
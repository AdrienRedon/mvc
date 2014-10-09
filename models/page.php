<?php

class Page extends \Core\Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table = 'pages';
	}
}
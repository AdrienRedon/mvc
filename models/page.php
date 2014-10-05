<?php

class Page extends Model
{

	public function __construct()
	{
		parent::__construct();
		$this->table = 'pages';
	}
}
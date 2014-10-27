<?php

class Post extends \Core\Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table = 'posts';
		$this->hidden = [];
	}
}
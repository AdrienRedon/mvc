<?php

class Post extends \Core\Model
{
    protected $table = 'posts';
    protected $fields = ['name', 'content', 'user_id'];
    protected $belongs_to = ['user' => 'user'];
}

<?php

class Post extends \Core\Model
{
    protected $table = 'posts';
    protected $fields = ['title', 'content', 'user_id']
    protected $belongs_to = ['user'];
}

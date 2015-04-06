<?php

class Post extends \Core\Model
{
    protected $table = 'posts';
    protected $fields = ['name', 'content', 'user_id'];
    protected $belongs_to = ['user' => 'user'];
    protected $belongs_to_many = ['categories' => ['category', 'post_category']]; // name => [model_to_belongs, transition_table]
}

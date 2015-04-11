<?php

namespace Models;

use \Core\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fields = ['name', 'content', 'user_id'];
    protected $belongs_to = ['user' => '\Models\User'];
    protected $belongs_to_many = ['categories' => ['\Models\Category', 'post_category']]; // name => [model_to_belongs, transition_table]
}

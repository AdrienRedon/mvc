<?php

namespace Models;

use \Core\Model;

class User extends Model
{
    protected $table = "users";
    protected $fields = ['login'];
    protected $hidden = ['password'];
    protected $has_many = ['posts' => '\Models\Post'];
}

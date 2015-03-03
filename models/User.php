<?php

class User extends \Core\Model
{
    protected $table = "users";
    protected $fields = ['login'];
    protected $hidden = ['password'];
    protected $has_many = ['post'];
}

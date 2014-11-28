<?php

class User extends \Core\Model
{
    protected $table = "users";
    protected $hidden = ['password'];
    protected $has_many = ['Post'];
}
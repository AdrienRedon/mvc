<?php

class Post extends \Core\Model
{
    protected $table = 'posts';
    protected $belongs_to = ['User'];
}
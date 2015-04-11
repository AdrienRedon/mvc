<?php

namespace Models;

use \Core\Model;

class Category extends Model {
    protected $table = 'categories';
    protected $fields = ['name'];
}
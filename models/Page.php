<?php

namespace Models;

use \Core\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $fields = ['name', 'content'];
}

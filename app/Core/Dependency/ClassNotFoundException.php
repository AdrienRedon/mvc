<?php 

namespace App\Core\Dependency;

use \Exception;

class ClassNotFoundException extends Exception 
{
    protected $message = 'Class not found';
}
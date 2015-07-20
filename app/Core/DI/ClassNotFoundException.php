<?php 

namespace App\Core\DI;

class ClassNotFoundException extends Exception 
{
    protected $message = 'Class not found';
}
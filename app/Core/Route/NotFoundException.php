<?php 

namespace App\Core\Route;

use \Exception;

class NotFoundException extends Exception 
{
    protected $message = 'Route not found';
}
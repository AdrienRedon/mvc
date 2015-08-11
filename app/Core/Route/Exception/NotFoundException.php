<?php 

namespace App\Core\Route\Exception;

use \Exception;

class NotFoundException extends Exception 
{
    protected $message = 'Route not found';
}
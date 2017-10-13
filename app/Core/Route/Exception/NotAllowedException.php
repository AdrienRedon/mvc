<?php 

namespace App\Core\Route\Exception;

use \Exception;

class NotAllowedException extends Exception 
{
    protected $message = 'Route not allowed';
}

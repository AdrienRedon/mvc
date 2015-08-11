<?php 

namespace App\Core\Route\Exception;

use \Exception;

class InvalidRouteException extends Exception 
{
    protected $message = 'Invalid Route';
}
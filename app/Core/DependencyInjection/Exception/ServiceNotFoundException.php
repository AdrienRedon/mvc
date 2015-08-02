<?php 

namespace App\Core\DependencyInjection\Exception;

use \Exception;

class ServiceNotFoundException extends Exception 
{
    protected $message = 'Class not found';
}
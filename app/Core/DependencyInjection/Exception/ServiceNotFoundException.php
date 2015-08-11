<?php 

namespace App\Core\DependencyInjection\Exception;

use \Exception;

class ServiceNotFoundException extends Exception 
{
    protected $message = 'Service not found';

    public function __construct($service = '')
    {
        $this->message = 'Service not found';
        if ($service != '') {
            $this->message .= ': ' . $service;
        }
    }
}
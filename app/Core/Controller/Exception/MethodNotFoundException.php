<?php 

namespace App\Core\Controller\Exception;

use \Exception;

class MethodNotFoundException extends Exception
{
    public function __construct($method = '')
    {
         $this->message = 'Method not found';
        if ($method != '') {
            $this->message .= ': ' . $method;
        }
    }
}
<?php

namespace Libs;

use \Libs\Interfaces\Mailer;
use \Core\Config;

class Mail implements MailerInterface
{

    protected $sender;

    public function __construct()
    {
        $config = Config::getInstance();
        $this->sender = $config->get('email');
    }

    public function send($receiver, $subject, $message)
    {
        $headers = 'From: ' . $this->sender;
        return mail($receiver, $subject, $message, $headers);
    }

    public function sendView($receiver, $view, $data = array())
    {
        
    }

}
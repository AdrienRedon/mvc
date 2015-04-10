<?php

namespace Libs;

use \Libs\Interfaces\Mailer;

class Mail implements MailerInterface
{

    protected $sender;

    public function __construct($sender)
    {
        $this->sender = $sender;
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
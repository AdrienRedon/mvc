<?php 

namespace Libs\Interfaces;

interface MailerInterface
{
    public function send($sender, $receiver, $message);
}
<?php

namespace Libs;

use \Libs\Interfaces\SessionInterface;

class Flash
{
    protected $session;
    const KEY = 'flash';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function set($msg)
    {
        $this->session->set(self::KEY, $msg);
    }

    public function get()
    {
        $flash = $this->session->get(self::KEY);
        $this->session->destroy(self::KEY);
        return $flash;
    }
}

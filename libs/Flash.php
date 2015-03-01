<?php

namespace Libs;

class Flash
{
	protected $session;
	const KEY = 'flash';

	public function __construct(\Libs\interfaces\SessionInterface $session)
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

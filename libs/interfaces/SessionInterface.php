<?php

namespace Libs\Interfaces; 

interface SessionInterface
{
	public function get($key);

	public function set($key, $value);
	
	public function destroy($key);
}
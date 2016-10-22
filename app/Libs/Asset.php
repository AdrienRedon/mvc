<?php

namespace App\Libs;

class Asset
{
  protected $json = null;
  
  public function path($file)
  {
    $parts = explode('.', $file);
    if ($this->isLocal()) {
      if ($parts[1] === 'css') {
        return;
      }
      return 'http://localhost:3003/assets/'.$file;
    }
    if (! $this->json) {
      $this->json = json_decode(file_get_contents(ROOT.'public/assets/assets.json'));
    }
    return WEBROOT . 'assets/' . $this->json->{$parts[0]}->{$parts[1]};
  }
  
  public function isLocal()
  {
    return true;
    return strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;
  }
}

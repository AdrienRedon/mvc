<?php

namespace App\Libs;

use App\Core\DependencyInjection\ContainerInterface;
use App\Core\DependencyInjection\ContainerAwareInterface;

class Asset implements ContainerAwareInterface
{
  protected $json = null;
  protected $container;
  protected $config;

  public function __construct(ContainerInterface $container)
  {
      $this->container = $container;
      $this->config = $this->container->resolve('Config');
  }

  public function setContainer(ContainerInterface $container = null) {
    $this->container = $container;
  }
  
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
    return $this->config->get('debug');
  }
}

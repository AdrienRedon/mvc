<?php 

namespace App\Core\Controller;

use App\Core\DependencyInjection\ContainerAware;
use App\Core\DependencyInjection\ContainerInterface;

class Controller extends ContainerAware
{
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }
}
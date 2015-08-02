<?php 

namespace App\Core\DependencyInjection;

class ContainerAware implements ContainerAwareInterface 
{
    protected $container

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
<?php 

namespace App\Core\DependencyInjection;

interface ContainerAwareInterface 
{
    public function setContainer(ContainerInterface $container = null);
}
<?php 

namespace App\Core\DependencyInjection;

interface ContainerInterface 
{
    public function register($name, $resolver);
    public function resolve($name);
}
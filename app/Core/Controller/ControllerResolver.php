<?php 

namespace App\Core\Controller;

use App\Core\DependencyInjection\ContainerInterface;
use App\Core\DependencyInjection\ContainerAwareInterface;

class ControllerResolver
{
    /**
     * Container
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Name
     * @var string
     */
    protected $name;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Create and return the controller
     * 
     * @return Callable
     */
    public function create($name)
    {
        $controllerParams = explode('@', $name);

        $controller = $this->container->resolve('App\Controller\\' . $controllerParams[0]);

        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }

        return array($controller, $controllerParams[1]);
    }
}
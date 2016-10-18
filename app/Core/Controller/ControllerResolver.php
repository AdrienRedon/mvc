<?php 
namespace App\Core\Controller;
use App\Core\DependencyInjection\ContainerInterface;
use App\Core\DependencyInjection\ContainerAwareInterface;
use App\Core\DependencyInjection\Exception\ServiceNotFoundException;
use App\Core\Controller\Exception\MethodNotFoundException;
class ControllerResolver
{
    /**
     * Container
     * @var ContainerInterface
     */
    protected $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * Create the controller and return the action
     * 
     * @return array Controller & method
     */
    public function getAction($name)
    {
        list($controller, $method) = explode('@', $name);
        try {  
            $controller = $this->container->resolve('App\Controller\\' . $controller);
        } catch (ServiceNotFoundException $e) {
            $filePath = ROOT . 'app/Controller/' . $controller . '.php';
            if (file_exists($filePath)) {
                include_once($filePath);
                $controllerName = 'App\Controller\\' . $controller;
                $controller = new $controllerName($this->container);
                $this->container->register($controllerName, $controller);
            } else {
                throw $e; 
            }
        }
        if (!method_exists($controller, $method)) {
            throw new MethodNotFoundException($method);
        }
        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }
        return array($controller, $method);
    }
}

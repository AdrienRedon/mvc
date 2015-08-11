<?php 

namespace App\Core\DependencyInjection;

use App\Core\DependencyInjection\Exception\ServiceNotFoundException;

class Container implements ContainerInterface
{

    /**
     * List of all registered custom constructor
     * @var array
     */
    protected $registry = array();

    /**
     * Set a resolver to a class
     * @param string   $name      Name of the class
     * @param Callable $resolver Function to call in order to resolve a class
     */
    public function register($name, $resolver)
    {
        $this->registry[$name] = $resolver;
    }
 
    /**
     * Get an object
     * @param  string $name Name of the class
     */
    public function resolve($name)
    {
        if(!isset($this->registry[$name])) {
            throw new ServiceNotFoundException($name);
        } elseif (is_callable($this->registry[$name])) {
            return $this->registry[$name]();
        } else {
            return $this->registry[$name];
        }
    }

}
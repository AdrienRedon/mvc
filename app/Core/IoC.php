<?php 

namespace App\Core;

use App\Core\Dependency\ClassNotFoundException;

class IoC
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
            throw new ClassNotFoundException();
        }
        return $this->registry[$name]();
    }

}
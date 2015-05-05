<?php

namespace Core;

use \ReflectionClass;
use \Exception;

class DIC 
{
    protected static $_instance;

    protected $registry = array();
    protected $singletons = array();
    protected $instances = array();

    /**
     * Bind an implementation to an interface
     * @param  string $interface Name (with namespace) of the interface
     * @param  string $class     Name (with namespace) of the class
     */
    public function bind($interface, $class)
    {
        $this->setSingleton($interface, function() use ($class) {
            return $this->get($class);
        });
    }

    /**
     * Set a resolver to a class
     * @param string   $key      Name of the class
     * @param Callable $resolver Function to call in order to resolve a class
     */
    public function set($key, Callable $resolver)
    {
        $this->registry[$key] = $resolver;
    }

    /**
     * Set a resolver to a singleton class
     * @param string   $key      Name of the class
     * @param Callable $resolver Function to call in ordr to resolve a class
     */
    public function setSingleton($key, Callable $resolver)
    {
        $this->singletons[$key] = $resolver;
    }

    /**
     * Save a object as a singleton
     * @param Object $instance Object to save
     */
    public function setInstance($instance)
    {
        $reflection = new ReflectionClass($instance);
        $key = $reflection->getName();
        $this->singletons[$key] = $instance;
        $this->instances[$key] = $instance;
    }

    /**
     * Get an object
     * @param  string $key Name of the class
     */
    public function get($key)
    {
        if(array_key_exists($key, $this->singletons))
        {
            if(!array_key_exists($key, $this->instances)) {
                $this->instances[$key] = $this->singletons[$key]();
            }
            return $this->instances[$key];
        }
        else 
        {
            return $this->make($key);
        }
    }

    /**
     * Create an object
     * @param  string $key Name of the class
     */
    public function make($key)
    {
        $reflected_class = new ReflectionClass($key);

        if($reflected_class->isInstantiable())
        {
            $constructor = $reflected_class->getConstructor();

            if($constructor) {
                $parameters = $constructor->getParameters();
                $constructor_parameters = array();
                foreach ($parameters as $parameter) 
                {
                    if($parameter->getClass()) 
                    {
                        $constructor_parameters[] = $this->get($parameter->getClass()->getName());
                    }
                    else 
                    {
                        $constructor_parameters[] = $parameter->getDefaultValue();
                    }
                }
                $class = $reflected_class->newInstanceArgs($constructor_parameters);
            }
            else 
            {
                $class = $reflected_class->newInstance();
            }
        }
        else 
        {
            throw new Exception('Unable to resolve '. $key);
        }

        return $class;
    }

    /**
     * Get instance of the Dependency Injection Container
     * @return DIC Dependency Injection Container
     */
    public static function getInstance() 
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new DIC();
        }
        return self::$_instance;
    }

}
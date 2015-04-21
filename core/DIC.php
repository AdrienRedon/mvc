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

    public function bind($interface, $class)
    {
        $this->setSingleton($interface, function() use ($class) {
            return $this->get($class);
        });
    }

    public function set($key, Callable $resolver)
    {
        $this->registry[$key] = $resolver;
    }

    public function setSingleton($key, Callable $resolver)
    {
        $this->singletons[$key] = $resolver;
    }

    public function setInstance($instance)
    {
        $reflection = new ReflectionClass($instance);
        $key = $reflection->getName();
        $this->instances[$key] = $instance;
    }

    public function get($key)
    {
        if(array_key_exists($key, $this->singletons))
        {
            if(!array_key_exists($key, $this->instances)) {
                $this->instances[$key] = $this->singletons[$key]();
            }
            return $this->singletons[$key]();
        }

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
                $this->instances[$key] = $reflected_class->newInstanceArgs($constructor_parameters);
            }
            else 
            {
                $this->instances[$key] = $reflected_class->newInstance();
            }
        }
        else 
        {
            throw new Exception('Unable to resolve '. $key);
        }
        return $this->instances[$key];
    }

    public static function getInstance() 
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new DIC();
        }
        return self::$_instance;
    }

}
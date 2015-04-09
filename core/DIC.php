<?php

namespace Core;

class DIC 
{

    public $registry = array();
    public $factories = array();
    private $instances = array();

    public function set($key, Callable $resolver)
    {
        $this->registry[$key] = $resolver;
    }

    public function setFactory($key, Callable $resolver)
    {
        $this->factories[$key] = $resolver;
    }

    public function setInstance($instance)
    {
        $reflection = new ReflectionClass($instance);
        $key = $reflection->getName();
        $this->instances[$key] = $instance;
    }

    public function get($key)
    {
        if(array_key_exists($key, $this->factories))
        {
            return $this->factories[$key]();
        }

        if(!array_key_exists($key, $this->instances))
        {
            if(isset($this->registry[$key]))
            {
                $this->instances[$key] = $this->registry[$key]();
            }
            else 
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
            }
        }
        return $this->instances[$key];
    }

}
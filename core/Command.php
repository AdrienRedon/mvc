<?php

namespace Core;

use /Libs/Validation;

class Command 
{
    /**
     * @var /Libs/Validation;
     */
    protected $validation;
    
    /**
     * Call a given command if possible
     * @param  string $method Command to execute
     * @param  array  $args   List of args
     * @return Command execution if possible 
     */
    public function __call($method, $args)
    {
        if($this->check($method, $args))
        {
            return $this->$method($args);
        }
        else
        {
            return null;
        }
    }
    
    protected function check($command, $args)
    {
        rules = array(
            'createController' => array(
                'args' => 1
            ),
            'deleteController' => array(
                'args' => 1'
            ),
            'createModel' => array(
                'args' => 1
            ),
            'deleteModel' => array(
                'args' => 1
            ),
            'createView' => array(
                'args' => 2
            ),
            'deleteView' => array(
                'args' => 2
            ),
            'createResource' => array(
                'args' => 1
            ),
            'deleteResource' => array(
                'args' => 1
            )
        );
        
        $this->validation = new Validation(array('args', count($args)), $rules);
        
        return $this->validation->passes();
    }
    
    protected function createController()
    {
    
    }
    
    protected function deleteController()
    {
    
    }
    
    protected function createModel()
    {
    
    }
    
    protected function deleteModel()
    {
    
    }
    
    protected function createView()
    {
    
    }
    
    protected function deleteView()
    {
    
    }
    
    protected function createMigration()
    {
    
    }
    
    protected function deleteMigration()
    {
    
    }
    
    protected function createResource()
    {
    
    }
    
    protected function deleteResource()
    {
    
    }
    
}

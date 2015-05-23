<?php

namespace Core;

use /Libs/Validation;
use /Core/File;

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
        $rules = array(
            'createController' => array(
                'args' => 1
            ),
            'deleteController' => array(
                'args' => 1
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
        $args = func_get_args();
        $name = $args[0];
        $controller = new File('controller', $name);
        $controller->content = "<?php\n\nnamespace Controllers\n\nuse \Core\Controller;\nuse \Core\App;\n\nclass " . ucfirst($name) . "Controller extends Controller\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t\$this->\$name = App::get('\Models\\" . ucfirst($name) . "');\n\t}"
        $controller->generate();
    }
    
    protected function deleteController()
    {
        $args = func_get_args();
        $name = $args[0];
        $controller = new File('controller', $name);
        $controller->delete();
    }
    
    protected function createModel()
    {
        $args = func_get_args();
        $name = $args[0];
        $controller = new File('model', $name);
        $controller->content = "<?php\n\nnamespace Models;\n\nuse \Core\Model;\n\nclass " . ucfirst($name). " extends Model\n{\n\tprotected \$table = 'table_name';\n\tprotected \$fields = [];\n\tprotected \$hidden = [];\n\tprotected \$has_one = [];\n\tprotected \$has_many = [];\n\tprotected \$belongs_to = [];\n\tprotected \$belongs_to_many = [];\n}";
        $controller->generate();
    }
    
    protected function deleteModel()
    {
        $args = func_get_args();
        $name = $args[0];
        $controller = new File('model', $name);
        $controller->delete();
    }
    
    protected function createView()
    {
        $args = func_get_args();
        $name = $args[0];
        $resource = $args[1];
        $controller = new File('view');
        $controller->setName($name, $resource);
        $controller->generate();
    }
    
    protected function deleteView()
    {
        $args = func_get_args();
        $name = $args[0];
        $resource = $args[1];
        $controller = new File('view');
        $controller->setName($name, $resource);
        $controller->delete();
    }
    
    protected function createMigration()
    {
        $args = func_get_args();
        $name = $args[0];
        $controller = new File('migration', $name);
        $controller->generate();
    }
    
    protected function deleteMigration()
    {
        $args = func_get_args();
        $name = $args[0];
        $controller = new File('migration', $name);
        $controller->delete();
    }
    
    protected function createResource()
    {
        $args = func_get_args();
        $name = $args[0];
        $methods = array_slice($args);
        if(empty($methods))
        {
            $methods = ['index', 'show', 'create', 'store', 'edit', 'update', 'delete'];
        }
        $this->createController($name, $methods);
        $this->createModel($name);
        $this->createMigration($name);
        foreach($methods as $method)
        {
            $this->createView($name, $method);
        }
    }
    
    protected function deleteResource()
    {
        $args = func_get_args();
        $name = $args[0];
        $methods = array_slice($args);
        $this->deleteController($name);
        $this->deleteModel($name);
        $this->deleteMigration($name);
        foreach($methods as $method)
        {
            $this->deleteView($name, $method);
        }
    }
    
}

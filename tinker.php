<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 11/10/2014
 * Time: 09:45
 */

if($argv[1] == 'generate')
{
    if($argv[2] == 'resource' && isset($argv[3]))
    {
        createResource($argv[3]);
    }
    else if($argv[2] == 'controller' && isset($argv[3]))
    {
        createController($argv[3]);
    }
    else if($argv[2] == 'model' && isset($argv[3]))
    {
        createModel($argv[3]);
    }
    else if($arg[2] == 'view' && isset($argv[3], $argv[4]))
    {
        createView($argv[3], $argv[4]);
    }
    else
    {
        die('Wrong commands !');
    }

    exit;
}

function createController($name)
{
    $filename = "controllers/{$name}_controller.php";

    if(!file_exists($filename))
    {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        fwrite($file, "<?php\n\nclass {$name}Controller extends \Core\Controller\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t\$this->page = \Core\Model::load('model_name');\n\t}\n}");
    }
    else
    {
        die("The $name controller already exists");
    }
}


function createModel($name)
{
    $filename = "models/$name.php";

    if (!file_exists($filename)) {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        fwrite($file, "<?php\n\nclass $name extends \Core\Model\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t\$this->table = 'table_name';\n\t\t\$this->hidden = [];\n\t}\n}");
    }
    else
    {
        die("The $name model already exists");
    }
}

function createView($resource, $name)
{
    $filename = "views/$resource/$name.php";
    
    if(!file_exists($filename))
    {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        fwrite($file, "");
    }
    else
    {
        die("The $name view already exists");
    }
}

function createResource($name)
{
    createController($name);
    createModel($name);
}




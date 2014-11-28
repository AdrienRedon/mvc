<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 11/10/2014
 * Time: 09:45
 */


if($argv[1] == 'generate' && isset($argv[2]))
{
    if($argv[2] == 'resource' && isset($argv[3]))
    {
        $methods = array_slice($argv, 4);
        createResource($argv[3], $methods);
    }
    else if($argv[2] == 'controller' && isset($argv[3]))
    {
        $methods = array_slice($argv, 4);
        createController($argv[3], $methods);

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
        die('Wrong command !');
        exit;
    }

    die("{$argv[3]} {$argv[2]} has been created");
    exit;
}
else if($argv[1] == 'delete' && isset($argv[2]))
{
    if($argv[2] == 'resource' && isset($argv[3]))
    {
        $methods = array_slice($argv, 4);
        deleteResource($argv[3], $methods);
    }
    else if($argv[2] == 'controller' && isset($argv[3]))
    {
        deleteController($argv[3]);
    }
    else if($argv[2] == 'model' && isset($argv[3]))
    {
        deleteModel($argv[3]);
    }
    else if($argv[2] == 'view' && isset($argv[3], $argv[4]))
    {
        deleteView($argv[3], $argv[4]);
    }
    else
    {
        die('Wrong command !');
        exit;
    }

    die("{$argv[3]} {$argv[2]} has been deleted");
    exit;
}

function createController($name, $methods = array())
{
    $filename = "controllers/{$name}_controller.php";

    if(!file_exists($filename))
    {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        $str = "<?php\n\nclass {$name}Controller extends \Core\Controller\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t\$this->page = \Core\Model::load('model_name');\n\t}";
        for($i = 0; $i < count($methods); $i++)
        {
            $str .= "\n\n\tpublic function {$methods[$i]}()\n\t{\n\t}";
        }
        $str .= "\n}";
        fwrite($file, $str);
        fclose($file);
    }
    else
    {
        die("The $name controller already exists");
    }
}

function deleteController($name)
{
    $filename = "controllers/$name.php";
    unlink($filename);
}

function createModel($name)
{
    $filename = "models/$name.php";

    if (!file_exists($filename)) {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        fwrite($file, "<?php\n\nclass $name extends \Core\Model\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t\$this->table = 'table_name';\n\t\t\$this->hidden = [];\n\t}\n}");
        fclose($file);
    }
    else
    {
        die("The $name model already exists");
    }
}

function deleteModel($name)
{
    $filename = "models/$name.php";
    unlink($filename);
}

function createView($resource, $name)
{
    $folder = "views/$resource";
    $filename = "$folder/$name.php";

    if(!file_exists($folder) || !is_dir($folder))
    {
        mkdir($folder);
    }

    if(!file_exists($filename))
    {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        fwrite($file, "");
        fclose($file);
    }
    else
    {
        die("The $name view already exists");
    }
}

function deleteView($resource, $name)
{
    $filename = "views/$resource/$name.php";
    unlink($filename);
}

function createResource($name, $methods)
{
    createController($name, $methods);
    createModel($name);
    for($i = 0; $i < count($methods); $i++)
    {
        createView($name, $methods[$i]);
    }
}

function deleteResource($name, $methods)
{
    deleteController($name);
    deleteModel($name);
    for($i = 0; $i < count($methods); $i++)
    {
        DeleteView($name, $methods[$i]);
    }
}




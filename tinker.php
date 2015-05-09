<?php

define('WEBROOT', str_replace('tinker.php', '', $_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('tinker.php', '', $_SERVER['SCRIPT_FILENAME']));

require_once('Autoloader.php');

use \Core\App;

Autoloader::register();
App::register();


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
    else if($argv[2] == 'view' && isset($argv[3], $argv[4]))
    {
        createView($argv[3], $argv[4]);
    }
    else if($argv[2] == 'migration' && isset($argv[3]))
    {
        createMigration($argv[3]);
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
else if($argv[1] == 'migrate' && isset($argv[2]))
{
    if($argv[2] == 'rollback' && isset($argv[3]))
    {
        $migration = App::get('\Migrations\\' . ucfirst($argv[2]));
        $migration->down();
    }
    else if(file_exists('migrations/' . $argv[2] . '.php'))
    {
        $migration = App::get('\Migrations\\' . ucfirst($argv[2]));
        $migration->up();
    }
}
else 
{
    die("Wrong command !");
    exit;
}

function createController($name, $methods = array())
{
    $filename = "controllers/" . ucfirst($name) . "Controller.php";

    if(!file_exists($filename))
    {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        $str = "<?php\n\nnamespace Controllers\n\nuse \Core\Controller;\nuse \Core\App;\n\nclass " . ucfirst($name) . "Controller extends Controller\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t\$this->$name = App::get('\Models\\" . ucfirst($name) . "');\n\t}";
        foreach($methods as $method)
        {
            $str .= "\n\n\tpublic function $method()\n\t{\n\t\t\n\t}\n";
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
    $filename = "controllers/". ucfirst($name) . "Controller.php";
    unlink($filename);
}

function createModel($name)
{
    $filename = "models/" . ucfirst($name) . ".php";

    if (!file_exists($filename)) {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        $str = "<?php\n\nnamespace Models;\n\nuse \Core\Model;\n\nclass " . ucfirst($name). " extends Model\n{\n\tprotected \$table = 'table_name';\n\tprotected \$fields = [];\n\tprotected \$hidden = [];\n\tprotected \$has_one = [];\n\tprotected \$has_many = [];\n\tprotected \$belongs_to = [];\n\tprotected \$belongs_to_many = [];\n}";
        fwrite($file, $str);
        fclose($file);
    }
    else
    {
        die("The $name model already exists");
    }
}

function deleteModel($name)
{
    $filename = "models/" . ucfirst($name) . ".php";
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
    if(empty($methods))
    {
        $methods = ['index', 'show', 'create', 'store', 'edit', 'update', 'delete'];
    }
    createController($name, $methods);
    createModel($name);
    createMigration($name);
    foreach($methods as $method)
    {
        createView($name, $method);
    }

    $routes = fopen('routes.php', 'a');
    $str = "\n\n";
    if($methods == ['index', 'show', 'create', 'store', 'edit', 'update', 'delete'])
    {
        $str .= "Route::resource('{$name}', '" . ucfirst($name) . "Controller')";
    }
    else {
        $str .= "Route::resource('{$name}', '" . ucfirst($name) . "Controller', ['only' => [";
        foreach($methods as $method)
        {
            $str .= "'$method', ";
        }
        $str = substr($str, 0, -2);
        $str .= "]])";
    }
    fwrite($routes, $str);
    fclose($routes);
}

function deleteResource($name, $methods)
{
    deleteController($name);
    deleteModel($name);
    deleteMigration($name);
    foreach($methods as $method)
    {
        deleteView($name, $method);
    }
}

function createMigration($name)
{
    $filename = "migrations/" . ucfirst($name) . "Migration.php";

    if(!file_exists($filename))
    {
        $file = fopen($filename, 'w') or die('Unable to open the file');
        $str = "<?php\n\nnamespace Migrations;\n\nuse \Core\Migration;\n\nclass " . ucfirst($name) . "Migration extends Migration\n{\n\tprotected \$table = 'table_name';\n\n\tpublic function up()\n\t{\n\t\t\n\t\t\$this->create();\n\t}\n\n\tpublic function down()\n\t{\n\t\t\$this->drop();\t\n}";
        fwrite($file, $str);
        fclose($file);
    }
    else
    {
        die("The $name migration already exists");
    }
}

function deleteMigration($name)
{
    $filename = "migrations/$name.php";
    unlink($filename);
}



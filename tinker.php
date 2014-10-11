<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 11/10/2014
 * Time: 09:45
 */

if($argv[1] == 'generate')
{
    if($argv[2] == 'controller' && isset($argv[3]))
    {
        $filename = "controllers/{$argv[3]}.php";

        if(!file_exists($filename))
        {
            $file = fopen($filename, 'w') or die("Impossible de generer le fichier");
            fwrite($file, "<?php\n\nclass {$argv[3]} extends \Core\Controller\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t}\n}");
        }
        else
        {
            die("Le controller est deja present");
        }
    }
    else if($argv[2] == 'model' && isset($argv[3]))
    {
        $filename = "models/{$argv[3]}.php";

        if (!file_exists($filename)) {
            $file = fopen($filename, 'w') or die("Impossible de generer le fichier");
            fwrite($file, "<?php\n\nclass {$argv[3]} extends \Core\Model\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t\t\$this->table = \"table_name\";\n\t\t\$this->hidden = [];\n\t}\n}");
        }
        else
        {
            die("Le model est deja present");
        }
    }
    else
    {
        echo 'Les arguments entrés ne sont pas corrects';
    }
}

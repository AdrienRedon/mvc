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
        $file = fopen("controllers/{$argv[3]}.php", "w") or die("Impossible d'ouvrir le fichier");
        fwrite($file, "<?php\n\nclass {$argv[3]} extends \Core\Controller\n{\n\t\n}");
    }
    else
    {
        echo 'Les aguments entrés ne sont pas corrects';
    }
}

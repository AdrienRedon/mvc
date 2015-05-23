<?php 

namespace Core;

class FileManager
{

    protected $name;

    protected $folder;

    protected $type;

    public $content;

    public function __construct($type, $name = null)
    {
        $this->type = $type;

        if(isset($name))
        {
            $this->setName($name);
        }
    }

    public function setName($name, $resource = null)
    {
        switch ($this->type) 
        {
            case 'controller':
                $this->name = "controllers/" . ucfirst($name) . "Controller.php";
                break;

            case 'model':
                $this->name = "models/" . ucfirst($name) . ".php";
                break;
            
            case 'view':
                $this->folder = "views/$resource";
                $this->name = $this->folder . "/" . ucfirst($name) . ".php";
                break;
            
            case 'migration':
                $this->name = "migrations/" . ucfirst($name) . "Migration.php";
                break;
            
            default:
                $this->name = $name;
                break;
        }
    }

    public function generate()
    {
        if($this->type == 'view' && !$this->checkFolder())
        {
            mkdir($this->folder);
        }

        if(!$this->checkExist())
        {
            $file = fopen($this->name, 'w') or die('Unable to open the file');
            fwrite($file, $this->content);
            fclose($file);
        }
        else
        {
            die("The file : \"$name\" already exists");
        }
    }

    public function delete()
    {
        unlink($this->name);
    }

    protected function checkExist()
    {
        return file_exists($this->name);
    }

    protected function checkFolder()
    {
        return file_exists($this->folder) && is_dir($this->folder);
    }
}
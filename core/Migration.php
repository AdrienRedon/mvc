<?php 

namespace Core;

class Migration 
{

    protected $db;

    protected $table;

    protected $fields = array();

    public function __construct(\Libs\Interfaces\DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function drop($table = null)
    {
        if(!$table)
        {
            $table = $this->table;
        }
        $this->db->execute("DROP TABLE $table");
    }

    public function id()
    {
        array_push($this->fields, array('id', "INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY"));
    }

    public function timestamps()
    {
        $this->timestamp('created_at');
        $this->timestamp('updated_at');
    }

    public function integer($name, $size = null)
    {
        array_push($this->fields, array($name, "INT($size)"));
    }

    public function varchar($name, $size = 255)
    {
        array_push($this->fields, array($name, "VARCHAR($size)"));
    }

    public function text($name)
    {
        array_push($this->fields, array($name, "TEXT"));
    }

    public function timestamp($name)
    {
        array_push($this->fields, array($name, "TIMESTAMPS"));
    }

    public function create($table = null)
    {
        if(!$table)
        {
            $table = $this->table;
        }
        $sql = "CREATE TABLE $table (";
        foreach ($this->fields as $field) 
        {
            $name = $field[0];
            $type = $field[1];
            $sql .= "$name $type, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ")";

        var_dump($sql);

        $this->db->execute($sql);
    }
}
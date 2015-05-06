<?php 

namespace Core;

use \Core\App;
use \Core\Field;
use \Libs\Interfaces\DatabaseInterface;

class Migration 
{

    protected $db;

    protected $table;

    protected $fields;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->fields = App::get('\Libs\Collection');
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
        return $this->integer('id')->size(8)->unsigned()->auto_increment()->primary();
    }

    public function timestamps()
    {
        $this->timestamp('created_at');
        $this->timestamp('updated_at');
    }

    public function integer($name, $size = null)
    {
        $field = new Field();
        $field->name = $name;
        $field->type = 'INT';
        $field->size = $size;

        $this->fields->push($field);
        return $this->fields->last();
    }

    public function varchar($name, $size = 255)
    {
        $field = new Field();
        $field->name = $name;
        $field->type = 'VARCHAR';
        $field->size = $size;

        $this->fields->push($field);
        return $this->fields->last();
    }

    public function text($name)
    {
        $field = new Field();
        $field->name = $name;
        $field->type = 'TEXT';

        $this->fields->push($field);
        return $this->fields->last();
    }

    public function timestamp($name)
    {
        $field = new Field();
        $field->name = $name;
        $field->type = 'TIMESTAMP';

        $this->fields->push($field);
        return $this->fields->last();
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
            $sql .= "$field, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ")";

        $this->db->execute($sql);
    }
}
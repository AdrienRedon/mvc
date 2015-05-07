<?php 

namespace Core;

use \Core\App;
use \Core\Field;
use \Libs\Interfaces\DatabaseInterface;

class Migration 
{

    /**
     * Implementation of the database interface
     * @var \Libs\Interfaces\DatabaseInterface
     */
    protected $db;

    /**
     * Name of the table to alter
     * @var string
     */
    protected $table;

    /**
     * List of fields
     * @var \Libs\Collection
     */
    protected $fields;

    /**
     * Constructor
     * @param DatabaseInterface $db Implementation of the database interface
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->fields = App::get('\Libs\Collection');
    }

    /**
     * Drop a table
     * @param  string $table Name of the table
     */
    public function drop($table = null)
    {
        if(!$table)
        {
            $table = $this->table;
        }
        $this->db->execute("DROP TABLE $table");
    }

    /**
     * Create an id field
     * @return \Core\Field id field
     */
    public function id()
    {
        return $this->integer('id')->size(8)->unsigned()->auto_increment()->primary();
    }

    /**
     * Create to fields to save the creation date and last update date
     */
    public function timestamps()
    {
        $this->timestamp('created_at');
        $this->timestamp('updated_at');
    }

    /**
     * Create an integer field
     * @param string $name Name of the field
     * @param int $size Size of the field
     * @return \Core\Field integer field
     */
    public function integer($name, $size = null)
    {
        $field = new Field();
        $field->name = $name;
        $field->type = 'INT';
        $field->size = $size;

        $this->fields->push($field);
        return $this->fields->last();
    }

    /**
     * Create an varchar field
     * @param string $name Name of the field
     * @param int $size Size of the field
     * @return \Core\Field varchar field
     */
    public function varchar($name, $size = 255)
    {
        $field = new Field();
        $field->name = $name;
        $field->type = 'VARCHAR';
        $field->size = $size;

        $this->fields->push($field);
        return $this->fields->last();
    }

    /**
     * Create an text field
     * @param string $name Name of the field
     * @return \Core\Field text field
     */
    public function text($name)
    {
        $field = new Field();
        $field->name = $name;
        $field->type = 'TEXT';

        $this->fields->push($field);
        return $this->fields->last();
    }

    /**
     * Create an timestamp field
     * @param string $name Name of the field
     * @return \Core\Field timestamp field
     */
    public function timestamp($name)
    {
        $field = new Field();
        $field->name = $name;
        $field->type = 'TIMESTAMP';

        $this->fields->push($field);
        return $this->fields->last();
    }

    /**
     * Create a table
     * @param  string $table Name of the table
     */
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
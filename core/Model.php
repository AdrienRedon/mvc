<?php 

namespace Core;

use \Libs\Collection;

class Model
{
    protected $db;
    
    protected $table;
    
    protected $timestamps = false;
    
    public $id;

    /**
     * List of the fillable fields
     * @var array
     */
    protected $fields;

    /**
     * Hidden fields
     */
    protected $hidden = array();

    /**
     * Querying Relations
     * @var array Name of the field => model to query
     */
    protected $has_one = array();
    protected $has_many = array();
    protected $belongs_to = array();
    protected $belongs_to_many = array();

    /**
     * Constructor
     */ 
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Read the given fields of the current record from the database
     * @param $fields array
     */
    public function read($fields = array())
    {
        foreach($fields as $k => $field)
        {
            if(!in_array($field, $this->fields))
            {
                unset($fields[$k]); 
            }
        }

        if(empty($fields))
        {
            $fields = '*';
        } 

        $sql = "SELECT $fields FROM {$this->table} WHERE id={$this->id}";
        $data = $this->db->query($sql);

        foreach ($data as $k => $v) 
        {
            $this->k = $v;
        }
    }
    
    /**
     * Create a record with the given data
     * @param $data array
     */ 
    public function create($data = array())
    {
        $args = array();
        $sql = "INSERT INTO {$this->table} (";
        if(empty($data))
        {
            foreach ($this->fields as $field) 
            {
                if(isset($this->$field))
                {
                    $sql .= "$field, ";
                }
            }
            $sql = substr($sql, 0, -2);
            $sql .= ") VALUES (";
            foreach ($this->fields as $field) 
            {
                if(isset($this->$field))
                {
                    $sql .= ":$field, ";
                    $args[$field] = $this->$field;
                }
            }
        }
        else
        {
            unset($data['id']);
            foreach ($data as $k => $v) 
            {
                $sql .= "$k, ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ") VALUES (";
            foreach ($data as $field => $value) 
            {
                $sql .= ":$field, ";
                $args[$field] = $value;
            }
        }
        
        if($timestamps)
        {
            $sql .= "created_at = ?,";
            $args['created_at'] = date('d/m/Y H:i:s');
        }
        
        $sql = substr($sql, 0, -2);
        $sql .= ")";

        $this->id = $this->db->execute($sql, $args); // set the id for the new record
    }
    
    /**
     * Update the current record into the database
     * @param $data array
     */ 
    public function update($data = array())
    {
        $sql = "UPDATE {$this->table} SET ";
        if(empty($data))
        {
            $id = $this->id;
            foreach ($this->fields as $field) 
            {
                if(isset($this->field))
                {
                    $sql .= "$field = ?, ";
                }
            }
        } 
        else
        {
            $id = $data['id'];
            foreach ($data as $field => $value) 
            {
                if($k != 'id')
                {
                    $sql .= "$field = ?, ";
                }
            }
        }
        if($timestamps)
        {
            $sql .= "updated_at = ?, ";
            $data[] = date('d/m/Y H:i:s');
        }
        
        $sql = substr($sql, 0, -2);
        $sql .= "WHERE id=$id";
        
        $this->db->execute($sql, $data); 
    }

    /**
     * Save the given data
     * @param $data array
     */
    public function save($data = array())
    {
        if(isset($this->id) || isset($data['id']))
        {
            $this->update($data);
        }
        else
        {
            $this->create($data);
        }
    }

    /**
     * Return the line with the given conditions from the table
     * @param $conditions
     * @return Collection
     */
    public function where(array $conditions)
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1 = 1";
        foreach($conditions as $fields => $value)
        {
            $sql .= " AND $fields = '$value'";
        }

        $results = $this->db->query($sql);

        foreach($results as $k=>$result)
        {
            $class = get_class($this);
            $object = new $class;
            foreach($result as $attribute=>$value)
            {
                $object->$attribute = $value;
            }
            $results[$k] = $object;
        }


        foreach ($this->hidden as $hidden)
        {
            foreach($results as $result)
            {
                if(isset($result->$hidden))
                {
                    unset($result->$hidden);
                }
            }
        }
        return $results;
    }

    /**
     * Return all the data
     * @return Collection
     */
    public function all()
    {
        return $this->where([]);
    }

    /**
     * Return the line with the given id from the table whitout relationship
     * @param $id integer
     * @return mixed $result Object
     */
    public function find($id)
    {
        $result = $this->where(['id' =>$id])->first();
        return $result;
    }

    /**
     * Return the first line from the table
     * @param string $fields
     * @return mixed $result
     */
    public function first($fields = '*')
    {
        $sql = "SELECT $fields FROM {$this->table}";
        $result = $this->db->query($sql)->first();
        
        foreach ($this->hidden as $hidden) 
        {
            if(isset($result->$hidden))
            {
                unset($result->$hidden);
            }
        }

        $class = get_class($this);

        $app = DIC::getInstance();

        $object = new $class($app->get('\Core\Database'));
        foreach($result as $attribute=>$value)
        {
            $object->$attribute = $value;
        }

        return $object;
    }

    /**
     * Delete a line from the table
     * @param int $id
     */
    public function delete($id = null)
    {
        if ($id == null) 
        {
            $id = $this->id;
        }
        $sql = "DELETE FROM {$this->table} WHERE id=$id";
        $this->db->query($sql);
    }

    /**
     * Load the given model
     * @param string $name Name of the model to load
     * @return Object Model loaded
     */
    static function load($name)
    {
        $app = DIC::getInstance();
        require_once(ROOT."models/".ucfirst($name).".php");
        return new $name($app->get('\Core\Database'));
    }

/**
 * Get and create (if first time) field from relationship between models
 * @param  string $key Name of the field
 * @return Object $this->$key
 */
    public function __get($key)
    {
        if(array_key_exists($key, $this->has_one)) 
        {
            if(!isset($this->$key))
            {
                $field = strtolower(get_class($this)).'_id';
                $this->$key = Model::load($this->has_one[$key])->where([$field => $this->id])->first();
            }
            return $this->$key;
        }

        if(array_key_exists($key, $this->has_many)) 
        {
            if(!isset($this->$key))
            {
                $field = strtolower(get_class($this)).'_id';
                $this->$key = Model::load($this->has_many[$key])->where([$field => $this->id]);
            }
            return $this->$key;
        }

        if(array_key_exists($key, $this->belongs_to))
        {
            if(!isset($this->$key))
            {
                $field = strtolower(get_class($this)).'_id';
                $this->$key = Model::load($this->has_one[$key])->find($this->$field);
            }
            return $this->$key;
        }
        
        if(array_key_exists($key, $this->belongs_to_many))
        {
            if(!isset($this->$key))
            {
                $first = strtolower(get_class($this));
                $second = strtolower($this->belongs_to_many[$key][0]);

                $first_field = $first.'_id';
                $second_field = $second.'_id';

                $ids = $this->db->query("
                    SELECT $second_field 
                    FROM {$this->belongs_to_many[$key][1]} 
                    WHERE $first_field = {$this->id}");

                $this->$key = new Collection();

                $model = Model::load($this->belongs_to_many[$key][0]);

                foreach($ids as $id) 
                {
                    $item = array($model->find($id->$second_field));
                    $this->$key->add($item);
                }
            }
            return $this->$key;
        }
        
    }

}

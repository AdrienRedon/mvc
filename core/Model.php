<?php 

namespace Core;

use Libs\Collection;

class Model
{
	protected $table;
	public $id;
	protected $db;

    /**
     * Relationships
     */
    protected $has_one = array();
    protected $has_many = array();
    protected $belongs_to = array();
    protected $belongs_to_many = array();

	/**
	 * Hidden fields
	 */
	protected $hidden = array();

	/**
	 * Constructor
	 */ 
	public function __construct()
	{
        $host = Config::getInstance()->get('sql_host');
        $base = Config::getInstance()->get('sql_base');
        $login = Config::getInstance()->get('sql_login');
        $password = Config::getInstance()->get('sql_password');
        
		$this->db = new Database($host, $base, $login, $password);
	}

	/**
	 * Read the given fields of a record from the database
	 * @param $fields
	 */
	public function read($fields = null)
	{
		if($fields == null)
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
		$sql = "INSERT INTO {$this->table} (";
		unset($data['id']);
		foreach ($data as $k => $v) 
		{
			$sql .= "$k,";
		}
		$sql = substr($sql, 0, -1);
		$sql .= ") VALUES (";
		foreach ($data as $k => $v) 
		{
			$sql .= "'$v',";
		}
		$sql = substr($sql, 0, -1);
		$sql .= ")";
		$this->db->query($sql);
	
	    // set the id for the new record
		$this->id = $this->db->getLastInsertedId();
	}
	
	/**
	 * Update the record into the database
	 * @param $data array Must contain the id of the record
	 */ 
	public function update($data = array())
	{
	    $sql = "UPDATE {$this->table} SET ";
		foreach ($data as $k => $v) 
		{
			if(k != 'id')
			{
				$sql .= "$k = '$v',";
			}
		}
		$sql = substr($sql, 0, -1);
		$sql .= "WHERE id={$data['id']}";
		
		$this->db->query($sql);	
	}

	/**
	 * Save the given data
	 * @param $data array
	 */
	public function save($data = array())
	{
		if(isset($data['id']) && !empty($data['id']))
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
        $object = new $class;
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
		require_once(ROOT."models/".ucfirst($name).".php");
		return new $name();
	}

/**
 * Get and create (if first time) field from relationship between models
 * @param  string $key Name of the field
 * @return Object $this->$key
 */
    public function __get($key)
    {
        if(in_array($key, $this->has_one)) 
        {
            if(!isset($this->$key))
            {
                $field = strtolower(get_class($this)).'_id';
                $this->$key = Model::load($key)->where([$field => $this->id])->first();
            }
            return $this->$key;
        }
        else if(in_array($key, $this->has_many)) 
        {
            if(!isset($this->$key))
            {
                $field = strtolower(get_class($this)).'_id';
                $this->$key = Model::load($key)->where([$field => $this->id]);
            }
            return $this->$key;
        }
        else if(in_array($key, $this->belongs_to))
        {
            if(!isset($this->$key))
            {
                $field = strtolower(get_class($this)).'_id';
                $this->$key = Model::load($key)->find($this->$field);
            }
            return $this->$key;
        }
        /**
         * @todo belongs_to_many
         */
    }

}

<?php 

namespace Core;

use Libs\Collection;

require_once(ROOT . 'core/database.php');

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
    protected $has_and_belongs_to = array();

    // Ajouter les model aux requètes (find, first, etc...)

	/**
	 * Hidden fields
	 */
	protected $hidden = array();

	public function __construct()
	{
		$this->db = new Database(SQL_HOST, SQL_BASE, SQL_LOGIN, SQL_PASS);

        //$this->has_one($this->has_one);
        //$this->has_many($this->has_many);
        //$this->belongs_to($this->belongs_to);
        //$this->has_and_belongs_to($this->has_and_belongs_to);
	}

	/**
	 * Lit une ligne dans la base de données par rapport à l'id de l'objet
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
	 * Save the given data
	 * @param $data
	 */
	public function save($data)
	{
		if(isset($data['id']) && !empty($data['id']))
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
		}
		else
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
		}

		if(!isset($data['id']))
		{
			$this->id = $this->db->getLastInsertedId();
		}
		else
		{
			$this->id = $data['id'];
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
     * Return the line with the given id from the table
     * @param $id integer
     * @return mixed $result Object
     */
    public function find($id)
    {
        $result = $this->where(['id' =>$id])->first();
        if(isset($result)) {
            foreach($this->has_many as $model)
            {
                $field = strtolower(get_class($this)).'_id';
                $result->$model = Model::load($model);
                $result->$model = $result->$model->where([$field => $id]);
            }
            foreach($this->has_one as $model)
            {
                $field = strtolower(get_class($this)).'_id';
                $result->$model = Model::load($model);
                $result->$model = $result->$model->where([$field => $id])->first();
            }
        }
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

        if(isset($result))
        {
            $result = $this->find($result->id);
        }

		return $result;
	}

	/**
	 * Delete a line from the table
	 * @param $id
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
     * @param $name
     * @return Model
     */
	static function load($name)
	{
		require_once(ROOT."models/$name.php");
		return new $name();
	}

}
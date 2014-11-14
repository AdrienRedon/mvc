<?php 

namespace Core;

use Libs\Collection;

require_once(ROOT . 'core/database.php');

class Model
{
	protected $table;
	protected $id;
	protected $db;

	/**
	 * Hidden fields
	 */
	protected $hidden;

	public function __construct()
	{
		$this->db = new Database(SQL_HOST, SQL_BASE, SQL_LOGIN, SQL_PASS);
		$this->hidden = [];
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
     * @param $id
     * @return $result
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id='$id'";
        $result = $this->db->query($sql)->first();

        foreach ($this->hidden as $hidden)
        {
            if(isset($result->$hidden))
            {
                unset($result->$hidden);
            }
        }
        return $result;
    }

	/**
	 * Return the first line from the table
	 * @param $fields
     * @return $result
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
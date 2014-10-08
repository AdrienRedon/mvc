<?php 

require_once(ROOT . 'core/database.php');


/*
 * Objet Model
 * Permet les interactions avec la base de données
 */
class Model
{
	protected $table;
	protected $id;
	protected $db;

	/**
	 * Champs cachés
	 */
	protected $hidden;

	public function __construct()
	{
		$this->db = new Database(SQL_HOST, SQL_BASE, SQL_LOGIN, SQL_PASS);
		$this->hidden = [];
	}

	/*
	 * Lit une ligne dans la base de données par rapport à l'id de l'objet
	 * @param $fields Liste des champs à récupérer
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

	/*
	 * Sauvegarde les données passées en paramètre dans la base de données
	 * @param $data Données à sauvegarder
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

	/*
	 * Permet de récupérer plusieurs lignes dans la base de données
	 * @param $data conditions de récupérations
	 */
	public function find($data = array())
	{
		$conditions = isset($data['conditions']) ? $data['conditions'] : '1=1';
		$fields = isset($data['fields']) ? $data['fields'] : '*';
		$limit = isset($data['limit']) ? $data['limit'] : '';
		$order = isset($data['order']) ? $data['order'] : 'id DESC';
		$sql = "SELECT $fields FROM {$this->table} WHERE $conditions ORDER BY $order $limit";
		$result = $this->db->query($sql);
		
		foreach ($this->hidden as $hidden) 
		{
			if(isset($result->$hidden))
			{
				unset($result->$hidden);
			}
		}
		return $result;
	}

	/*
	 * Permet de récupérer la première ligne dans la base de données
	 * @param $data conditions de récupérations
	 */
	public function first($data = array())
	{
		$conditions = isset($data['conditions']) ? $data['conditions'] : '1=1';
		$fields = isset($data['fields']) ? $data['fields'] : '*';
		$limit = isset($data['limit']) ? $data['limit'] : '';
		$order = isset($data['order']) ? $data['order'] : 'id DESC';
		$sql = "SELECT $fields FROM {$this->table} WHERE $conditions ORDER BY $order $limit";
		$result = $this->db->queryFirst($sql);
		
		foreach ($this->hidden as $hidden) 
		{
			if(isset($result->$hidden))
			{
				unset($result->$hidden);
			}
		}
		return $result;
	}

	/*
	 * Permet de supprimer une ligne dans la base de données
	 * @param $id ID de la ligne à supprimer
	 */
	public function delete($id = null)
	{
		if ($id == null) 
		{
			$id = $this->id;
		}
		$sql = "DELTE FROM {$this->table} WHERE id=$id";
		$this->db->query($sql);
	}

	static function load($name)
	{
		require_once(ROOT."models/$name.php");
		return new $name();
	}
}
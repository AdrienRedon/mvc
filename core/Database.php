<?php 

namespace Core;

use \PDO;
use \Libs\Collection;

class Database
{

	protected $db;

	public function __construct($host, $base, $login, $password)
	{
		$this->db = new PDO("mysql:host=$host;dbname=$base", $login, $password);
	}

	/**
	 * Execute une requête SQL et retourne le résultat
	 * @param $sql string Requête à exécuter
	 * @return Collection Collection of object return by the query
	 */
	public function query($sql, $args = array())
	{
		$req = $this->db->prepare($sql);
		$req->execute($args);
		return new Collection($req->fetchAll(PDO::FETCH_OBJ));
	}

	public function execute($sql, $args = array())
	{
		$req = $this->db->prepare($sql);
		$req->execute($args);
		return $this->getLastInsertedId();
	}


	public function getLastInsertedId()
	{
		return $this->db->lastInsertId();
	}
}

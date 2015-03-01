<?php 

namespace Core;

class Database
{

	protected $db;

	public function __construct($host, $base, $login, $password)
	{
		$this->db = new \PDO("mysql:host=$host;dbname=$base", $login, $password);
	}

	/**
	 * Execute une requête SQL et retourne le résultat
	 * @param  $sql     string Requête à exécuter
	 * @return Object[] Tableau contenant l'ensemble des lignes retournées par la requête sous forme d'objet.
	 */
	public function query($sql)
	{
		$req = $this->db->prepare($sql);
		$req->execute();
		return new \Libs\Collection($req->fetchAll(\PDO::FETCH_OBJ));
	}


	public function getLastInsertedId()
	{
		return $this->db->lastInsertedId();
	}
}

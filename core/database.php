<?php 

class Database
{

	protected $db;

	public function __construct($host, $base, $login, $password)
	{
		$this->db = new PDO("mysql:host=$host;dbname=$base", $login, $password);
	}

	/**
	 * Execute une requête SQL et retourne le résultat
	 * @param  $sql     Requête à exécuter
	 * @return Object[] Tableau contenant l'ensemble des lignes retournées par la requête sous forme d'objet.
	 */
	public function query($sql)
	{
		$req = $this->db->prepare($sql);
		$req->execute();
		return $req->fetchAll(PDO::FETCH_OBJ);
	}

	/**
	 * Execute une requête SQL et retourne le premier résultat trouvé
	 * @param  $sql   Requête à executer
	 * @return Object Première ligne retourné par la requête sous forme d'objet
	 */
	public function queryFirst($sql)
	{
		$data = $this->query($sql);
		return count($data) > 0 ? $data[0] : null;
	}

	public function getLastInsertedId()
	{
		return $db->lastInsertedId();
	}
}
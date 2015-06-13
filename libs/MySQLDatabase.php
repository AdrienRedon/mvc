<?php 

namespace Libs;

use \Libs\Interfaces\DatabaseInterface;
use \Libs\Collection;
use \Core\Config;
use \PDO;
use \Exception;

class MySQLDatabase implements DatabaseInterface
{

    protected $db;

    public function __construct(Config $config)
    {
        $host = $config->get('sql_host');
        $base = $config->get('sql_base');
        $login = $config->get('sql_login');
        $password = $config->get('sql_password');

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$base", $login, $password);
        } catch(Exception $e) {
            die("Unable to connect to MySQL Database");
        }
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

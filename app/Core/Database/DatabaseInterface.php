<?php 
namespace App\Core\Database;
interface DatabaseInterface
{
    /**
     * Get data from the database
     * @param  string $sql  Request
     * @param  array  $args Arguments for the request
     * @return Collection   Data from database
     */
    public function query($sql, $args = array());
    /**
     * Execute an action to the database
     * @param  string $sql  Request
     * @param  array  $args Arguments for the request
     * @return integer      Last inserted id
     */
    public function execute($sql, $args = array());
}

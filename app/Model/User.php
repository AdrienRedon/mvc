<?php
namespace App\Model;
use App\Core\Model\Model;

class User extends Model
{
    protected $table = "users";
    protected $fields = ['mail'];
    protected $hidden = ['password'];
    public function check_password($password)
    {
        $sql = "SELECT password FROM {$this->table} WHERE id={$this->id}";
        $data = $this->db->query($sql);
        return password_verify($password, $data->first()->password);
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
  protected $table = "users";
  protected $primaryKey = "id";
  protected $allowedFields = ['username', 'email', 'name', 'password'];
  public function findUser()
  {

    return $this->db->table("users")
      ->get()->getRowArray();
  }
  public function findUserByUsername($username)
  {
    return $this->db->table("users")
      ->where("username", $username)
      ->get()->getFirstRow();
  }
}

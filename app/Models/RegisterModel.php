<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class RegisterModel extends Model
{
  protected $table = "users";
  protected $primaryKey = "id";
  protected $allowedFields = ['username', 'email', 'name', 'password'];

  public function findByUsername($username)
  {

    return $this->db->table('users')->getWhere([
      'username' => $username
    ])->getResult();
  }
  public function store($data)
  {
    return $this->insert($data);
  }
}

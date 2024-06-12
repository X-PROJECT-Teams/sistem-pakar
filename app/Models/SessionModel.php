<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model
{
  protected $table = "sessions";
  protected $primaryKey = "id";
  protected $allowedFields = ['id', 'user_id'];
  public function findSessionUnique($session_id)
  {
    return $this->db->table("sessions")
      ->where("id", $session_id)
      ->get()->getFirstRow();
  }
}

<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class SessionModel extends Model
{
  protected $table = "sessions";
  protected $primaryKey = "id";
  protected $allowedFields = ['id', 'user_id', 'expired', 'access_token', 'created_at'];
  public function findSessionUnique($session_id)
  {
    return $this->db->table("sessions")
      ->where("id", $session_id)
      ->get()->getFirstRow();
  }
  public function findSessionByUserId(string $user_id)
  {
    $session = $this->asArray()
      ->where('user_id', $user_id)
      ->first();
    if (!$session) {
      throw new Exception('Session not found');
    }
    return $session;
  }
  public function findSessionByEmail(string $email)
  {
    $userModel = new UserModel();
    $user = $userModel->findUserByEmail($email);
    if (!$user) {
      throw new Exception('User Not found');
    }
    $session = $this->findSessionByUserId($user['id']);
    return $session;
  }
  public function findSessionByTokenJoinByUser(string $token)
  {
    return $this->asArray()
      ->where('access_token', $token)
      ->first();
  }
  public function findSessionByToken(string $token)
  {
    $session = $this->asArray()
      ->where('access_token', $token)
      ->first();
    if (!$session) {
      throw new Exception('Session not found');
    }
    return $session;
  }
  public function removeSessionByEmail(string $email)
  {
    $user = $this->findSessionByEmail($email);
    if (!$user) {
      throw new Exception('User Not found');
    }
    return $this->where("user_id", $user['user_id'])->delete();
  }
  public function removeSessionById(int $id)
  {
    return $this->where("user_id", $id)->delete();
  }
  public function removeSessionByToken(string $token)
  {
    return $this->where('access_token', $token)->delete();
  }
}

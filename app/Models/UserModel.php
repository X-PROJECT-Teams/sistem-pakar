<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
  protected $table = "users";
  protected $allowedFields = [
    'id',
    'username',
    'email',
    'name',
    'is_active',
    'is_admin',
    'password',
    'created_at',
    'update_at'
  ];
  protected $updatedField = 'updated_at';

  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];
  protected $primaryKey = "id";

  public function findUserByUsername(string $username)
  {
    $user = $this->asArray()->where(['username' => $username])->first();
    if (!$user) {
      throw new Exception('User does not exist for specified username');
    }
    return $user;
  }
  public function removeUserByEmail(string $email)
  {
    $user = $this->where("email", $email)->delete();
    if (!$user) {
      throw new Exception("Cannot delete user data because it is not registered in the database");
    }
    return $user;
  }
  public function findUserByEmailOrUsername(string $emailOrUsername)
  {
    $user = $this->asArray()
      ->where('email', $emailOrUsername)
      ->orWhere('username', $emailOrUsername)
      ->first();
    if (!$user) {
      throw new Exception('Email or password is incorrect');
    }
    return $user;
  }
  public function findUserByEmail(string $email)
  {
    $user = $this
      ->asArray()
      ->where(['email' => $email])
      ->first();

    if (!$user)
      throw new Exception('User does not exist for specified email address');

    return $user;
  }
  protected function beforeInsert(array $data): array
  {
    return $this->getUpdatedWithHashedPassword($data);
  }

  protected function beforeUpdate(array $data): array
  {
    return $this->getUpdatedWithHashedPassword($data);
  }
  private function hashPassword(string $plaintText)
  {
    return password_hash($plaintText, PASSWORD_BCRYPT);
  }
  private function getUpdatedWithHashedPassword(array $data): array
  {
    if (isset($data['data']['password'])) {
      $plaintext = $data['data']['password'];
      $data['data']['password'] = $this->hashPassword($plaintext);
    }
    return $data;
  }
  public function updateByUsername(string $username, $data)
  {
    return $this->where("username", $username)->set($data)->update();
  }
}

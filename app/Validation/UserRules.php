<?php

namespace App\Validation;

use App\Models\UserModel;
use Exception;

class UserRules
{
  public function validateUser(string $str, string $fields, array $data): bool
  {
    try {
      $model = new UserModel();
      $user = $model->findUserByEmailOrUsername($data['account']);
      return password_verify($data['password'], $user['password']);
    } catch (Exception $ex) {
      return false;
    }
  }
  public function isAccountValid(string $str, string $fields, array $data): bool
  {
    try {
      $model = new UserModel();
      $model->findUserByEmailOrUsername($data['email']);
      return true;
    } catch (Exception $ex) {
      return false;
    }
  }
}

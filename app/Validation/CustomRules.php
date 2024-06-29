<?php

namespace App\Validation;

use App\Models\UserModel;
use Exception;

class CustomRules
{
  public function emailExists(string $str, string $fields, array $data): bool
  {
    try {
      $model = new UserModel();
      $model->findUserByEmailOrUsername($str);
      return true;
    } catch (Exception $ex) {
      return false;
    }
  }
}

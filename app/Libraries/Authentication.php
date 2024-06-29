<?php


namespace App\Libraries;

use App\Models\SessionModel;
use CodeIgniter\Session\Session;
use App\Models\UserModel;
use Config\App;
use Exception;

class Authentication
{
  protected $session;
  protected $sessionModel;
  public function __construct(Session $session, SessionModel $sessionModel)
  {
    helper("jwt");
    $this->session = $session;
    $this->sessionModel = $sessionModel;
  }
  public function isLogin(string $token)
  {
    try {
      $dataJWT =  getJWTData($token);
      if ($dataJWT->data->is_active != "1") return false;
      $this->sessionModel->findSessionByEmail($dataJWT->data->email);
      return true;
    } catch (Exception $e) {
      return false;
    }
  }
  public function isLoginAdmin(string $token)
  {
    try {
      $dataJWT =  getJWTData($token);
      if ($dataJWT->data->is_admin != "1") return false;
      if ($dataJWT->data->is_active != "1") return false;
      return true;
    } catch (Exception $e) {
      return false;
    }
  }
  public function findToken(string $token)
  {
    try {
      $token = $this->sessionModel->findSessionByToken($token);
      return $token;
    } catch (Exception $e) {
      return "gada";
    }
  }
  public function findUserById(int $userId)
  {
    try {
      return $this->sessionModel->findSessionByUserId($userId);
    } catch (Exception $e) {
      return null;
    }
  }
  public function findUserDataByToken(string $token)
  {
    try {
      return $this->sessionModel->findSessionByTokenJoinByUser($token);
    } catch (Exception $e) {
      return null;
    }
  }
  public function isUserLoggedIn(int $userId)
  {
    try {
      $this->sessionModel->findSessionByUserId($userId);
      return true;
    } catch (Exception $e) {
      return false;
    }
  }
  public function isExpired($expired)
  {
    $currentTime = time();
    $expiredTime = strtotime($expired);

    return $currentTime >= $expiredTime;
  }
  public function addAuth(string $userId, string $access_token, string $expired)
  {
    return $this->sessionModel->save([
      'user_id' => $userId,
      'access_token' => $access_token,
      'expired' => $expired
    ]);
  }
  public function removeAuth(string $token)
  {
    return $this->sessionModel->removeSessionByToken($token);
  }
  public function removeAuthByEmail(string $email)
  {
    return $this->sessionModel->removeSessionByEmail($email);
  }
}

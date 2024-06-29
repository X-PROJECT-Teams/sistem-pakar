<?php

namespace App\Controllers;

use App\Libraries\Authentication;
use App\Models\QuizionerModel;
use App\Models\SessionModel;
use App\Models\UserModel;
use Config\Services;
use Exception;

class Test extends BaseController
{
  public function __construct()
  {
    helper('jwt');
  }
  public function index()
  {
    $session  = session();
    $userModel = new UserModel();
    $token = Services::request()->getCookie("access_token");
    $questionModel = new QuizionerModel();
    $dataQuestion = $questionModel->findAllWithDetail();
    if ($token) {
      $data = getJWTData($token);
      $data = $userModel->findUserByEmail($data->data->email);
      unset($data['password']);
      return view('home/index', [
        'username' => $data['username'],
        'is_admin' => $data['is_admin'],
        'questions' => $dataQuestion,
        'success_insert' => $session->get("success_insert")
      ]);
    }
    return view('test/home', ['questions' => $dataQuestion]);
  }
  public function testPost()
  {
    $session = session();
    $sessionModel = new SessionModel();
    $userModel = new UserModel();
    $auth = new Authentication($session, $sessionModel);

    $user = $userModel->findUserByEmail("rayyreall2902@gmail.com");
    $dataJWT =  getSignedJWTForUser($user);
    if ($auth->isUserLoggedIn($user['id'])) {
      return $this->getResponse(['message' => 'User logged in']);
    }
    $waktu = (time() + intVal(getenv('JWT_TIME_TO_LIVE')));
    $sesi = null;
    try {
      $sesi = $sessionModel->findSessionByUserId($user['id']);
    } catch (Exception $e) {
      $sesi = null;
    } finally {
      if ($sesi == null) {
        $auth->addAuth($user['id'], $dataJWT['access_token'], $waktu);
      }
      return redirect()
        ->setCookie("access_token",  $dataJWT['access_token'], getenv('JWT_TIME_TO_LIVE'))
        ->to("/test/auth");
    }
  }
  public function testAuth()
  {
    $session = session();
    $sessionModel = new SessionModel();
    $token = $this->request->getCookie('access_token');
    $dataJWT =  getJWTData((string)$token);
    return $this->getResponse([
      "data" => $token,
      'test' => $session->get("test"),
      'result' =>  $sessionModel->findSessionByEmail("admin29@admin.com"),
      'jwt' => $dataJWT
    ]);
  }
}

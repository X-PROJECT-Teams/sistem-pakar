<?php

namespace App\Controllers;

use App\Domain\User;
use App\Models\LoginModel;
use App\Controllers\Home;
use App\Domain\Session;
use App\Models\SessionModel;
use Config\Services;

class LoginController extends BaseController
{
  protected $LoginModel;
  public function __construct()
  {
    helper('form');
    $this->LoginModel = new LoginModel();
  }
  public function index()
  {
    return view("login/index");
  }

  public function postlogin()
  {
    $username = $this->request->getPost("username");
    $password = $this->request->getPost("password");

    $validationResult = $this->isValidateInput();
    if ($validationResult !== true) {
      return redirect()->back()->withInput()->with('errors', $validationResult);
    }
    $loginModel = new LoginModel();
    $getData = $loginModel->findUserByUsername($username);
    if (isset($getData)) {
      $userData = new User();
      $userData->id = $getData->id;
      $userData->name = $getData->name;
      $userData->password = $getData->password;
      $userData->email = $getData->email;

      if (password_verify((string) $password, $userData->password)) {


        return redirect()->to("/");
      } else {
        $data = [
          "password_error" => "Password anda masukkan salah!"
        ];
        return view("login/index", $data);
      }
    } else {
      $data = [
        "username_error" => "Username anda tidak terdaftar didalam database harap ketik ulang"
      ];
      return view("login/index", $data);
    }
    //return redirect()->to("/users/register");
  }
  private function sessionSave(LoginModel $userData)
  {
    $session_data = session();
    $session = new Session();
    $sessionModel = new SessionModel();

    $session->id = uniqid();
    $session->user_id = $userData->id;

    $data = [
      "id" => $session->id,
      "user_id" => $session->user_id
    ];
    if ($sessionModel->insert($data)) {
      $session_data->set(Session::$COOKIE_NAME, $session->id);
    } else {
      $data = [
        "session_error" => "Gagal membuat session harap login ulang!"
      ];
      return view("login/index", $data);
    }
  }
  protected function isValidateInput()
  {
    $validation = Services::validation();
    $validation->setRules([
      'username' => 'required|alpha_numeric|min_length[3]|max_length[50]',
      'password' => 'required|min_length[6]|max_length[255]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
      return $validation->getErrors();
    }
    return true;
  }
}

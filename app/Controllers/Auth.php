<?php

namespace App\Controllers;

use App\Domain\User;
use App\Models\LoginModel;
use App\Controllers\Home;
use App\Domain\Session;
use App\Libraries\Authentication;
use App\Models\SessionModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class Auth extends BaseController
{

  public function __construct()
  {
    helper(['form', 'jwt']);
  }
  public function index()
  {
    $session = session();
    if ($session->get("logout")) {
      return view('User/login', ['logout' => true]);
    }
    return view("User/login");
  }
  public function logout()
  {
    $session = session();
    $sessionModel = new SessionModel();
    $auth = new Authentication($session, $sessionModel);

    $token = Services::request()->getCookie("access_token");
    if ($token == null) {
      $token = '';
    }
    try {
      $data = getJWTData($token);
      $auth->removeAuthByEmail($data->data->email);
      return redirect()->to('/auth/login')->deleteCookie("access_token")->with("logout", '1');
    } catch (Exception $e) {
      $auth->removeAuth($token);
      return redirect()->to('/auth/login')->deleteCookie("access_token")->with('session_error', 'Token anda Invalid Harap login ulang!');
    }
  }
  public function login()
  {
    $session = session();
    if ($session->get("logout")) {
      return view('User/login', ['logout' => true]);
    } else if ($session->get("session_error")) {
      return view('User/login', ['session_error' => true]);
    }
    return view('User/login');
  }
  public function register()
  {
    return view("User/register");
  }
  public function editAccount()
  {
    try {
      $session = session();
      $rules = [
        'username' => 'required|min_length[3]|max_length[255]'
      ];
      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        return redirect()->to("/account/list")->withCookies();
      }
      $userModel = new UserModel();
      $data =  $userModel->findUserByUsername($input['username']);
      unset($data['password']);
      $token = Services::request()->getCookie("access_token");
      $dataJWT = getJWTData($token);
      $dataJWT = $userModel->findUserByEmail($dataJWT->data->email);
      $error_msg = $session->get("error_input");
      return view('User/edit', [
        'username' => $dataJWT['username'],
        'is_admin' => $dataJWT['is_admin'],
        'error_input' => $error_msg,
        'data' => $data
      ]);
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
      //return  $this->getResponse(['err' => $e->getMessage()]);
    }
  }
  public function postEditAccount()
  {
    try {
      session();
      $rules = [
        'username' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|min_length[6]|max_length[255]',
        'name' => 'required',
        'is_active' => 'required|in_list[0,1]',
        'is_admin' => "required|in_list[0,1]"
      ];

      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        foreach ($this->validator->getErrors() as $error) {
          return redirect()->back()->withInput()->with("error_input", $error);
        }
      }
      $userModel = new UserModel();
      $data = [
        "email" => $input['email'],
        'name' => $input['name'],
        "is_active" => $input['is_active'],
        'is_admin' => $input['is_admin']
      ];
      $userModel->updateByUsername($input['username'], $data);
      return redirect()->to("/account/list")->withCookies()->with("success_edit", "1");
    } catch (Exception $e) {
      //return $this->getResponse(["error" => $e->getMessage()]);
    }
  }
  public function postRegister()
  {
    $rules = [
      'name' => 'required',
      'username' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
      'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
      'password' => 'required|min_length[6]|max_length[255]',
    ];

    $input = $this->getRequestInput($this->request);

    if (!$this->validateRequest($input, $rules)) {
      return $this->getResponse(
        [
          "error" =>         $this->validator->getErrors(),
          "status_code" => ResponseInterface::HTTP_BAD_REQUEST
        ]
      );
    }

    if (!isset($input['is_admin'])) {
      $input['is_admin'] = 0;
    }
    if (isset($input['is_active'])) {
      $input['is_active'] = 1;
    }

    $userModel = new UserModel();
    $userModel->save($input);

    return redirect()->to("/auth/login");
  }

  public function postLogin()
  {
    $session = session();
    $sessionModel = new SessionModel();
    $auth = new Authentication($session, $sessionModel);

    $userInfo = $this->getLogin();
    if (isset($userInfo['error'])) {
      return view('User/login', array('error' => $userInfo['error']));
    }
    $dataJWT =  getSignedJWTForUser($userInfo);
    /*
    if ($auth->isUserLoggedIn($userInfo['id'])) {
      $dataAuth = $auth->findUserById($userInfo['id']);
      return redirect()
        ->setCookie("access_token",  $dataAuth['access_token'], getenv('JWT_TIME_TO_LIVE'))
        ->to("/");
    }*/
    $waktu = (time() + intVal(getenv('JWT_TIME_TO_LIVE')));
    $sesi = null;
    try {
      $sesi = $sessionModel->findSessionByUserId($userInfo['id']);
    } catch (Exception $e) {
      $sesi = null;
    } finally {
      if ($sesi == null) {
        $auth->addAuth($userInfo['id'], $dataJWT['access_token'], $waktu);
      }
      return redirect()
        ->setCookie("access_token",  $dataJWT['access_token'], getenv('JWT_TIME_TO_LIVE'))
        ->to("/");
    }
  }
  public function listAccounts()
  {
    $session = session();
    $userModel = new UserModel();
    $data = $userModel->findAll();
    for ($i = 0; $i < count($data); $i++) {
      if (isset($data[$i]['password'])) {
        unset($data[$i]['password']);
      }
    }
    $token = Services::request()->getCookie("access_token");
    $dataJWT = getJWTData($token);
    $dataJWT = $userModel->findUserByEmail($dataJWT->data->email);
    return view('User/list-account', [
      "users" => $data,
      'username' => $dataJWT['username'],
      'is_admin' => $dataJWT['is_admin'],
      'success_remove' => $session->get("success_remove"),
      'error_validate' => $session->get("error_validate"),
      'success_edit' => $session->get("success_edit"),
    ]);
  }
  public function deleteAccount()
  {
    try {
      helper('jwt');
      $rules = [
        'email' => 'required'
      ];

      $errors = [
        'email' => [
          'validateUser' => 'Invalid Email'
        ]
      ];

      $input = $this->getRequestInput($this->request);
      $userModel = new UserModel();

      if (!$this->validateRequest($input, $rules, $errors)) {
        return redirect()->to("/account/list")->withCookies()->with("error_validate", "Data yang anda kirim tidak valid!");
      }
      $userModel->removeUserByEmail($input['email']);
      return redirect()->to("/account/list")->withCookies()->with("success_remove", "1");
    } catch (Exception $err) {
      return $this->getResponse([
        'error' => $err->getMessage()
      ]);
    }
  }
  private function getLogin()
  {
    $rules = [
      'account' => 'required|min_length[3]|max_length[255]',
      'password' => 'required|min_length[6]|max_length[255]|validateUser[account, password]'
    ];

    $errors = [
      'password' => [
        'validateUser' => 'Invalid login credentials provided'
      ]
    ];

    $input = $this->getRequestInput($this->request);
    $userModel = new UserModel();

    if (!$this->validateRequest($input, $rules, $errors)) {
      return [
        'error' =>  $this->validator->getErrors()
      ];
    }
    $user = $userModel->findUserByEmailOrUsername($input['account']);
    return $user;
  }
  private function getJWTForUser(string $email, int $responseCode = ResponseInterface::HTTP_OK)
  {
    try {
      $model = new UserModel();
      $user = $model->findUserByEmail($email);
      unset($user['password']);

      helper('jwt');
      return [
        'user' => $user,
        'access_token' => getSignedJWTForUser($user)
      ];
    } catch (Exception $ex) {
      throw new Exception($ex->getMessage());
    }
  }
  public function setUserCookie(string $jwt_token)
  {
    $session = session();
    $data = getJWTData($jwt_token);
    $session->set('access_token', $jwt_token);
    $session->set("data", $data);
    $session->set('is_loggin', true);
  }
}

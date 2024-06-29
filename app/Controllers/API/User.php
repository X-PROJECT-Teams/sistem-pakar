<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;
use Firebase\JWT\JWT;
use ReflectionException;

class User extends BaseController
{
  protected $session;

  public function __construct()
  {
    $this->session = session();
  }
  public function register()
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

    $userModel = new UserModel();
    $userModel->save($input);

    return $this->getJWTForUser($input['email'], ResponseInterface::HTTP_CREATED);
  }
  public function login()
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
      return $this->getResponse(
        $this->validator->getErrors(),
        ResponseInterface::HTTP_BAD_REQUEST
      );
    }
    $user = $userModel->findUserByEmailOrUsername($input['account']);
    return $this->getJWTForUser($user['email']);
  }
  public function removeUser()
  {
    try {
      helper('jwt');
      $rules = [
        'email' => 'required',
        'token' => 'required'
      ];

      $errors = [
        'email' => [
          'validateUser' => 'Invalid Email'
        ]
      ];

      $input = $this->getRequestInput($this->request);
      $userModel = new UserModel();

      if (!$this->validateRequest($input, $rules, $errors)) {
        return $this->getResponse(
          $this->validator->getErrors(),
          ResponseInterface::HTTP_BAD_REQUEST
        );
      }

      validateJWTFromRequest($input['token']);

      $dataJWT = getJWTData($input['token']);
      $superUser = $userModel->findUserByEmail($dataJWT->data->email);
      $user = $userModel->findUserByEmail($input['email']);

      if ($superUser['is_admin'] !== 1) {
        return redirect()->to("/error_page");
      }
      unset($user['password']);
      $userModel->removeUserByEmail($input['email']);

      return redirect()->to("/list/account");
    } catch (Exception $err) {
      return redirect()->to("/page_error");
    }
  }
  public function testJWT()
  {
    helper('jwt');
    $authenticationHeader = $this->request->getServer('HTTP_AUTHORIZATION');
    try {
      $encodedToken = getJWTFromRequest($authenticationHeader);
      $key = Services::getSecretKey();
      $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
      return $this->getResponse([
        'token' => $decodedToken
      ]);
    } catch (Exception $ex) {
      return Services::response()
        ->setJSON(
          [
            'error' => $ex->getMessage()
          ]
        )
        ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
    }
  }

  private function getJWTForUser(string $email, int $responseCode = ResponseInterface::HTTP_OK)
  {
    try {
      $model = new UserModel();
      $user = $model->findUserByEmail($email);
      unset($user['password']);

      helper('jwt');
      return [
        'data' => [
          'user' => $user,
          'access_token' => getSignedJWTForUser($user)
        ]
      ];
    } catch (Exception $ex) {
      return $this->getResponse(
        [
          'error' => $ex->getMessage()
        ],
        $responseCode
      );
    }
  }
}

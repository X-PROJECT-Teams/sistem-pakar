<?php

namespace App\Filters;

use App\Libraries\Authentication;
use App\Models\SessionModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Exception;

class JWTAuth implements FilterInterface
{
  use ResponseTrait;

  protected $sessionModel;

  public function __construct()
  {
    // initialize
    helper('jwt');
    $this->sessionModel = new SessionModel();
  }
  public function before(RequestInterface $request, $arguments = null)
  {
    $session = session();
    $auth = new Authentication($session, $this->sessionModel);
    $token = Services::request()->getCookie('access_token');
    try {
      if ($token == null) {
        $token = "";
      }
      if ($auth->isLogin($token)) {
        return $request;
      } else {
        return redirect()->to("/auth/login")->with("error", "Harap Login Ulang");
      }
    } catch (Exception $ex) {
      return redirect()->to("/auth/login")->with("error", $ex->getMessage());
    }
  }

  /**
   * Allows After filters to inspect and modify the response object as needed. This method does not allow 
   * any way to stop execution of other after filters, short of throwing an Exception or Error.
   *
   * @param RequestInterface  $request
   * @param ResponseInterface $response
   * @param array|null        $arguments
   *
   * @return mixed
   */
  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // 
  }
}

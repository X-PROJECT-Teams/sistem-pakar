<?php

namespace App\Filters;

use App\Models\SessionModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Authentication;
use Config\Services;
use Exception;

class AdminAuth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
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
            if ($auth->isLoginAdmin($token)) redirect()->to("/auth/login")->with("error", "ERROR ANDA BUKAN ADMIN TIDAK DAPAT MENGAKSES FITUR INI");
            return redirect()->to("/test/auth")->with("test", var_dump($auth->isLoginAdmin($token)));
        } catch (Exception $ex) {
            return redirect()->to("/auth/login")->with("error", $ex->getMessage());
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}

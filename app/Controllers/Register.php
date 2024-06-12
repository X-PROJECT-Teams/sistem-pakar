<?php

namespace App\Controllers;

use App\Models\RegisterModel;
use Config\Database;
use Config\Services;

class Register extends BaseController
{
  public function __construct()
  {
    helper('form');
  }
  public function index(): string
  {

    return view('register/index');
  }

  public function store()
  {
    $validationResult = $this->isValidateInput();
    if ($validationResult !== true) {
      return redirect()->back()->withInput()->with('errors', $validationResult);
    }

    $registerModel = new RegisterModel();
    $db = Database::connect();
    $db->transStart();

    if ($this->isUserExists($this->request->getPost('username'), $registerModel)) {
      $db->transRollback();
      return redirect()->back()->with('error', 'User ID already exists');
    }


    $data = [
      'username' => $this->request->getPost('username'),
      'email' => $this->request->getPost('email'),
      'name' => $this->request->getPost('name'),
      'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT)
    ];

    if ($registerModel->store($data)) {
      $db->transComplete();
      if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'An error occurred while creating the user.');
      }
      return redirect()->to('/users/login')->with('message', 'User created successfully');
    } else {
      $db->transRollback();
      return redirect()->back()->withInput()->with('error', 'An error occurred while creating');
    }
  }
  private function isUserExists($username, RegisterModel $registerModel)
  {
    return isset($registerModel->findByUsername($username)[0]);
  }
  protected function isValidateInput()
  {
    $validation = Services::validation();
    $validation->setRules([
      'username' => 'required|alpha_numeric|min_length[3]|max_length[50]',
      'email' => 'required|valid_email|max_length[100]',
      'name' => 'required|alpha_space|min_length[3]|max_length[100]',
      'password' => 'required|min_length[6]|max_length[255]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
      return $validation->getErrors();
    }
    return true;
  }
}

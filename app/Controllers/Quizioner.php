<?php

namespace App\Controllers;

use App\Database\Migrations\QuestionInformation;
use App\Domain\Question;
use App\Models\LoginModel;
use App\Models\QuestionInformationModel;
use App\Models\QuizionerModel;
use App\Models\RatingModel;
use App\Models\UserModel;
use Config\Services;
use Exception;

class Quizioner extends BaseController
{
  public function __construct()
  {
    helper('form');
  }
  public function index(): string
  {
    return view('home/index');
  }
  public function listRating()
  {
    $ratingModel = new RatingModel();
    $session = session();
    $userModel = new UserModel();
    $token = Services::request()->getCookie("access_token");
    if ($token) {
      $data = getJWTData($token);
      $data = $userModel->findUserByEmail($data->data->email);
      unset($data['password']);

      return view('admin/list-rating', [
        'username' => $data['username'],
        'is_admin' => $data['is_admin'],
        "data" => $ratingModel->findAllRatingWithUser()
      ]);
    }
  }
  public function postHasilQuestion()
  {
    try {
      session();
      $input = $this->getRequestInput($this->request);
      $questionInformation = new QuestionInformationModel();
      $total = 0;
      foreach ($input as $key => $value) {
        $total += (int)$value;
      }
      $userModel = new UserModel();
      $ratingModel = new RatingModel();

      $data = $questionInformation->findAllWithFormula();
      $output = [];
      foreach ($data as $value) {
        if (($total >= $value['range_min']) && ($total <= $value['range_max'])) {
          $output = $value;
          break;
        }
      }


      $token = Services::request()->getCookie("access_token");
      if ($token) {
        $data = getJWTData($token);
        $users = $userModel->findUserByEmail($data->data->email);
        unset($users['password']);

        return view('home/hasil', [
          'username' => $users['username'],
          'is_admin' => $users['is_admin'],
          'data' => $output,
          'index_score' => $total,
          'is_rating' => $ratingModel->isRatingById($users['id'])
        ]);
      }

      return view("home/hasil", ['data' => $output, 'index_score' => $total, 'is_rating' => true]);
    } catch (Exception $e) {
      return $this->getResponse(["error" => $e->getMessage()]);
    }
  }
  public function postRatingQuestion()
  {
    try {
      session();

      $rules = [
        'rating' => 'required|numeric'
      ];
      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        foreach ($this->validator->getErrors() as $error) {
          return redirect()->back()->withInput()->with("error_input", $error);
        }
      }
      $ratingModel = new RatingModel();
      $userModel = new UserModel();
      $token = Services::request()->getCookie("access_token");
      if ($token) {
        $data = getJWTData($token);
        $data = $userModel->findUserByEmail($data->data->email);
        if ($ratingModel->isRatingById($data['id'])) {
          return redirect()->to("/")->withCookies();
        };
        $ratingModel->save([
          'user_id' => $data['id'],
          'rating' => $input['rating'],
          'komentar' => isset($input['comment']) ? $input['comment'] : ""
        ]);
        return redirect()->to("/")->withCookies()->with("success_insert", "1");
      }
    } catch (Exception $e) {
      return $this->getResponse(["error" => $e->getMessage()]);
    }
  }
  public function adminPostFormula()
  {
    try {
      session();
      $rules = [
        'judul' => 'required|min_length[3]|max_length[255]',
        'range_min' => 'required|numeric',
        'range_max' => 'required|numeric'
      ];

      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        foreach ($this->validator->getErrors() as $error) {
          return redirect()->back()->withInput()->with("error_input", $error);
        }
      }

      $questionInformation = new  QuestionInformationModel();
      $userModel = new UserModel();
      $token = Services::request()->getCookie("access_token");
      if ($token) {
        $data = getJWTData($token);
        $data = $userModel->findUserByEmail($data->data->email);
        unset($data['password']);
        $data = [
          "name" => $input['judul'],
          "range_min" => $input['range_min'],
          "range_max" => $input['range_max']
        ];
        if (isset($input['tingkat'])) $data['tingkat'] = $input['tingkat'];
        if (isset($input['dampak'])) $data['dampak'] = $input['dampak'];
        if (isset($input['pelaksanaan'])) $data['pelaksanaan'] = $input['pelaksanaan'];
        if (isset($input['pencegahan'])) $data['pencegahan'] = $input['pencegahan'];

        $questionInformation->insertInformation($data);
        return redirect()->to("/admin/create-formula")->withCookies()->with("success_insert", "1");
      }
    } catch (Exception $e) {
      return $this->getResponse(["error" => $e->getMessage()]);
    }
  }
  public function adminPostCreate()
  {
    try {
      session();
      $rules = [
        'soal' => 'required|min_length[1]|max_length[255]',
        'pilihan_1' => 'required',
        'pilihan_2' => 'required',
        'pilihan_3' => 'required'
      ];

      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        foreach ($this->validator->getErrors() as $error) {
          return redirect()->back()->withInput()->with("error_input", $error);
        }
      }
      $questionModel = new QuizionerModel();
      $userModel = new UserModel();
      $token = Services::request()->getCookie("access_token");
      if ($token) {
        $data = getJWTData($token);
        $data = $userModel->findUserByEmail($data->data->email);
        unset($data['password']);
        $data = [
          "name" => $input['soal'],
          "pilihan_1" => $input['pilihan_1'],
          "pilihan_2" => $input['pilihan_2'],
          "pilihan_3" => $input['pilihan_3'],
          "created_by" => $data["id"]
        ];
        $questionModel->insertQuestionWithDetail($data);
        return redirect()->to("/admin/create-quiz")->withCookies()->with("success_insert", "1");
      }
    } catch (Exception $e) {
      return $this->getResponse(["error" => $e->getMessage()]);
    }
  }
  public function adminListQuiz()
  {
    $questionModel = new QuizionerModel();
    $session = session();
    $userModel = new UserModel();
    $token = Services::request()->getCookie("access_token");
    if ($token) {
      $data = getJWTData($token);
      $data = $userModel->findUserByEmail($data->data->email);
      unset($data['password']);
      return view('admin/list-quiz', [
        'username' => $data['username'],
        'is_admin' => $data['is_admin'],
        "questions" => $questionModel->findAllWithDetail(),
        'success_edit' => $session->get("succcess_edit"),
        "success_remove" => $session->get("success_remove")
      ]);
    }
  }
  public function editQuestion()
  {
    try {
      $session = session();
      $rules = [
        'question' => 'required'
      ];
      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        return redirect()->back()->withCookies()->with("error_input", "1");
      }
      $quizionerModel = new QuizionerModel();
      $userModel = new UserModel();
      $data =  $quizionerModel->findWithDetail($input['question']);
      unset($data['password']);
      $token = Services::request()->getCookie("access_token");
      $dataJWT = getJWTData($token);
      $dataJWT = $userModel->findUserByEmail($dataJWT->data->email);
      $error_msg = $session->get("error_input");
      return view('admin/edit-quiz', [
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
  public function deleteQuestion()
  {
    try {
      session();
      $rules = [
        'quest_id' => 'required'
      ];
      $input = $this->getRequestInput($this->request);

      if (!$this->validateRequest($input, $rules)) {
        return redirect()->to("/account/list")->withCookies()->with("error_validate", "Data yang anda kirim tidak valid!");
      }
      $questionModel = new QuizionerModel();
      $questionModel->removeQuestionWithDetail($input['quest_id']);
      return redirect()->to("/admin/list-quiz")->withCookies()->with("success_remove", "1");
    } catch (Exception $err) {
      return $this->getResponse([
        'error' => $err->getMessage()
      ]);
    }
  }
  public function postEditQuestion()
  {
    try {
      session();
      $rules = [
        'question_id' => 'required',
        'soal' => 'required|min_length[1]|max_length[255]',
        'pilihan_1' => 'required',
        'pilihan_2' => 'required',
        'pilihan_3' => 'required'
      ];

      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        foreach ($this->validator->getErrors() as $error) {
          return redirect()->back()->withInput()->with("error_input", $error);
        }
      }
      $quizionerModel = new QuizionerModel();
      $data = [
        "question_id" => $input['question_id'],
        'name' => $input['soal'],
        "pilihan_1" => $input['pilihan_1'],
        "pilihan_2" => $input['pilihan_2'],
        "pilihan_3" => $input['pilihan_3'],
      ];
      $quizionerModel->updateWithDetail($data);
      return redirect()->to("/admin/list-quiz")->withCookies()->with("success_edit", "1");
    } catch (Exception $e) {
      //return $this->getResponse(["error" => $e->getMessage()]);
    }
  }
  public function adminCreate()
  {
    $session = session();
    $userModel = new UserModel();
    $error_msg = $session->get("error_input");
    $token = Services::request()->getCookie("access_token");
    if ($token) {
      $data = getJWTData($token);
      $data = $userModel->findUserByEmail($data->data->email);
      unset($data['password']);
      return view('admin/create-quiz', [
        'username' => $data['username'],
        'is_admin' => $data['is_admin'],
        'error_input' => $error_msg,
        "success_insert" => $session->get("success_insert")
      ]);
    }
  }
  public function adminListFormula()
  {
    $questionInformationModel = new QuestionInformationModel();
    helper("jwt");
    $session = session();
    $userModel = new UserModel();
    $token = Services::request()->getCookie("access_token");
    if ($token) {
      $data = getJWTData($token);
      $data = $userModel->findUserByEmail($data->data->email);
      unset($data['password']);
      return view('admin/list-formula', [
        'username' => $data['username'],
        'is_admin' => $data['is_admin'],
        "questions" => $questionInformationModel->findAllWithFormula(),
        'success_edit' => $session->get("succcess_edit"),
        "success_remove" => $session->get("success_remove")
      ]);
    }
  }
  public function adminPostEditFormula()
  {
    try {
      session();
      $rules = [
        'id' => 'required|numeric',
        'judul' => 'required|min_length[3]|max_length[255]',
        'range_min' => 'required|numeric',
        'range_max' => 'required|numeric'
      ];
      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        foreach ($this->validator->getErrors() as $error) {
          return redirect()->back()->withInput()->with("error_input", $error);
        }
      }
      $quizionerModel = new QuestionInformationModel();
      if (!isset($input['tingkat'])) $input['tingkat'] = null;
      if (!isset($input['dampak'])) $input['dampak'] = null;
      if (!isset($input['pelaksanaan'])) $input['pelaksanaan'] = null;
      if (!isset($input['pencegahan'])) $input['pencegahan'] = null;
      $quizionerModel->updateWithFormula($input);
      return redirect()->to("/admin/list-formula")->withCookies()->with("success_edit", "1");
    } catch (Exception $e) {
      return $this->getResponse(["error" => $e->getMessage()]);
    }
  }
  public function adminDeleteFormula()
  {
    try {
      session();
      $rules = [
        'id' => 'required|numeric'
      ];
      $input = $this->getRequestInput($this->request);

      if (!$this->validateRequest($input, $rules)) {
        return redirect()->to("/admin/list-formula")->withCookies()->with("error_validate", "Data yang anda kirim tidak valid!");
      }
      $questionModel = new QuestionInformationModel();
      $questionModel->removeFormulaByID($input['id']);
      return redirect()->to("/admin/list-formula")->withCookies()->with("success_remove", "1");
    } catch (Exception $err) {
      return $this->getResponse([
        'error' => $err->getMessage()
      ]);
    }
  }
  public function adminEditFormula()
  {
    try {
      $session = session();
      $rules = [
        'id' => 'required|numeric'
      ];
      $input = $this->getRequestInput($this->request);
      if (!$this->validateRequest($input, $rules)) {
        return redirect()->back()->withCookies()->with("error_input", "1");
      }
      $quizionerInformationModel = new QuestionInformationModel();
      $userModel = new UserModel();
      $data =  $quizionerInformationModel->findAllWithDetail($input['id']);
      if (empty($data)) return redirect()->to("/admin/list-formula")->withCookies()->with("error_input", "1");

      $token = Services::request()->getCookie("access_token");
      $dataJWT = getJWTData($token);
      $dataJWT = $userModel->findUserByEmail($dataJWT->data->email);
      $error_msg = $session->get("error_input");
      return view('admin/edit-formula', [
        'username' => $dataJWT['username'],
        'is_admin' => $dataJWT['is_admin'],
        'error_input' => $error_msg,
        'data' => $data[0]
      ]);
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
      //return  $this->getResponse(['err' => $e->getMessage()]);
    }
  }
  public function adminCreateFormula()
  {
    $session = session();
    $userModel = new UserModel();
    $error_msg = $session->get("error_input");
    $token = Services::request()->getCookie("access_token");
    if ($token) {
      $data = getJWTData($token);
      $data = $userModel->findUserByEmail($data->data->email);
      unset($data['password']);
      return view('admin/create-formula', [
        'username' => $data['username'],
        'is_admin' => $data['is_admin'],
        'error_input' => $error_msg,
        "success_insert" => $session->get("success_insert")
      ]);
    }
  }
  public function create_question()
  {
    $questionModel = new QuizionerModel();
    $userModel = new UserModel();

    if (($validationResult = $this->isValidationInput()) !== true) {
      return redirect()->back()->withInput()->with('errors', $validationResult);
    }
    $quest = new Question();
    $user = $userModel->findUserByUsername(session()->get("username"));
    if (!isset($user)) {
      return redirect()->to("/users/login");
    }

    $quest->name = $this->request->getVar('name');
    $questionModel->insertQuestion($quest, $user->id);
    return redirect()->to("/api/create_quiz")->with("message", "Berhasil Menambahkan user ke dalam database");
  }
  private function isValidationInput()
  {
    $validation = Services::validation();
    $validation->setRules([
      'name' => 'required|alpha_space|max_length[100]',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
      return $validation->getErrors();
    }
    return true;
  }
  private function sumScore()
  {
    $score = [
      "kesadaranUmum"
    ];
  }
}

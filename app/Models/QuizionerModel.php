<?php

namespace App\Models;

use App\Domain\Question;
use CodeIgniter\Model;
use App\Models\UserModel;
use Exception;

class QuizionerModel extends Model
{
  protected $table = "question";
  protected $primaryKey = "id";
  protected $allowedFields = ['id', 'name', 'created_by'];
  public function findSessionUnique($session_id)
  {
    return $this->db->table($this->table)
      ->where("id", $session_id)
      ->get()->getFirstRow();
  }
  public function findAllQuestion()
  {
    return $this->db->table($this->table)
      ->get()->getRow();
  }
  public function insertQuestionWithDetail($data)
  {
    $questionDetailModel = new QuestionDetailModel();
    $this->db->transStart();
    if ($this->save([
      "name" => $data["name"],
      "created_by" => $data["created_by"]
    ])) {
      $questionId = $this->getInsertID();
      $questionDetailData = [
        ['id_question' => $questionId, 'index_score' => 1, 'description' => $data['pilihan_1']],
        ['id_question' => $questionId, 'index_score' => 2, 'description' => $data['pilihan_2']],
        ['id_question' => $questionId, 'index_score' => 3, 'description' => $data['pilihan_3']],
      ];
      if ($questionDetailModel->insertBatch($questionDetailData)) {
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
          $this->db->transRollback();
          throw new Exception('An error occurred while creating the question.');
        }
        return true;
      } else {
        $this->db->transRollback();
        throw new Exception('An error occurred while creating the question.');
      }
    } else {
      $this->db->transRollback();
      throw new Exception('An error occurred while creating the question.');
    }
  }
  public function insertQuestion(Question $question, $id)
  {
    $questionDetailModel = new QuestionDetailModel();
    $this->db->transStart();
    if (isset($user)) {
      $data = [
        "id" => $question->id,
        "name" => $question->name,
        "created_by" => $id
      ];
      if ($data = $this->insert((object) $data)) {
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
          throw new Exception('An error occurred while creating the question.');
        }
        return $data;
      };
    } else {
      $this->db->transRollback();
      throw new Exception('Error user tidak terdaftar dalam database');
    }
  }
  public function findAllWithDetail()
  {
    return $this->select('question.*, users.name as nama, question_detail.id_question, question_detail.index_score, question_detail.description')
      ->join('question_detail', 'question.id = question_detail.id_question')
      ->join("users", "users.id = question.created_by")
      ->findAll();
  }
  public function updateWithDetail($data)
  {
    $questionDetailModel = new QuestionDetailModel();
    $this->db->transStart();
    if ($this->where("id", $data['question_id'])->set([
      'name' => $data['name']
    ])->update()) {
      $questionId = $data['question_id'];
      for ($i = 1; $i < 4; $i++) {
        $questionDetailModel->where("id_question", $questionId)->where("index_score", $i)
          ->set([
            'description' => $data['pilihan_' . $i]
          ])->update();
      }
      $this->db->transComplete();
      if ($this->db->transStatus() === false) {
        throw new Exception('An error occurred while creating the question.');
      }
      return true;
    } else {
      $this->db->transRollback();
      throw new Exception('An error occurred while update the question.');
    }
  }
  public function removeQuestionWithDetail($questionId)
  {
    $questionDetailModel = new QuestionDetailModel();
    $this->db->transStart();
    if ($questionDetailModel->where("id_question", $questionId)->delete()) {
      if ($this->where("id", $questionId)->delete()) {
        $this->db->transComplete();
        if ($this->db->transStatus() === false)
          throw new Exception('An error occurred while creating the question.');
      } else {
        $this->db->transRollback();
        throw new Exception('An error occurred while remove the question.');
      }
    }
  }
  public function findWithDetail($question_id)
  {
    return $this->select('question.*, users.name as nama, question_detail.id_question, question_detail.index_score, question_detail.description')
      ->where("question.id", $question_id)
      ->join('question_detail', 'question.id = question_detail.id_question')
      ->join("users", "users.id = question.created_by")
      ->findAll();
  }
}

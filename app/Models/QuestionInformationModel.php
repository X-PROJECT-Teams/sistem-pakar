<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class QuestionInformationModel extends Model
{
    protected $table            = 'question_information';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'name',
        'description',
        'tingkat',
        'dampak',
        'pelaksanaan',
        'pencegahan'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findAllWithFormula()
    {
        return $this->select('question_information.*,  question_formula.range_min, question_formula.range_max')
            ->join('question_formula', 'question_information.id = question_formula.question_info_id')
            ->findAll();
    }
    public function findAllWithDetail($id)
    {
        return $this->select('question_information.*,  question_formula.range_min, question_formula.range_max')
            ->where("question_information.id", $id)
            ->join('question_formula', 'question_information.id = question_formula.question_info_id')
            ->findAll();
    }
    public function removeFormulaByID($id)
    {
        $questionFormulaModel = new QuestionFormulaModel();
        $this->db->transStart();
        if ($questionFormulaModel->where("question_info_id", $id)->delete()) {
            if ($this->where("id", $id)->delete()) {
                $this->db->transComplete();
                if ($this->db->transStatus() === false)
                    throw new Exception('An error occurred while creating the question.');
            } else {
                $this->db->transRollback();
                throw new Exception('An error occurred while remove the question.');
            }
        }
    }
    public function updateWithFormula($data)
    {
        $questionFormulaModel = new QuestionFormulaModel();
        $this->db->transStart();
        if ($this->where("id", $data['id'])->set([
            'name' => $data['judul'],
            'tingkat' => $data['tingkat'],
            'dampak' => $data['dampak'],
            'pelaksanaan' => $data['pelaksanaan'],
            'pencegahan' => $data['pencegahan']
        ])->update()) {
            $questionId = $data['id'];
            $questionFormulaModel->where("question_info_id", $questionId)->set([
                'range_min' => $data['range_min'],
                'range_max' => $data['range_max']
            ])->update();
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
    public function insertInformation($data)
    {
        $questionFormulaModel = new QuestionFormulaModel();
        $this->db->transStart();
        if ($this->save([
            "name" => $data["name"],
            'tingkat' => $data['tingkat'],
            'dampak' => $data['dampak'],
            'pelaksanaan' => $data['pelaksanaan'],
            'pencegahan' => $data['pencegahan']
        ])) {
            $questionId = $this->getInsertID();
            if ($questionFormulaModel->save([
                'question_info_id' => $questionId,
                'range_min' => $data['range_min'],
                'range_max' => $data['range_max']
            ])) {
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
}

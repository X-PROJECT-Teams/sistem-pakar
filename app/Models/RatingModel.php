<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class RatingModel extends Model
{
    protected $table            = 'rating';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'user_id',
        'rating',
        'komentar'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;

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

    public function findRatingById(string $userId)
    {
        $user = $this
            ->asArray()
            ->where(['user_id' => $userId])
            ->first();
        return $user;
    }
    public function findAllRatingWithUser()
    {
        return $this->select('rating.*,users.username, users.name as nama')
            ->join("users", "users.id = rating.user_id")
            ->findAll();
    }
    public function isRatingById(string $userId)
    {
        $rating = $this->findRatingById($userId);
        if ($rating) {
            return true;
        }
        return false;
    }
}

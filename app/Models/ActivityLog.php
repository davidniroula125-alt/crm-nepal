<?php namespace App\Models;

use CodeIgniter\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['company_id', 'user_id', 'action', 'entity_type', 'entity_id', 'created_at'];
    protected $createdField = 'created_at';

    public function getByCompany(int $companyId, int $limit = 20): array
    {
        return $this->where('company_id', $companyId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}

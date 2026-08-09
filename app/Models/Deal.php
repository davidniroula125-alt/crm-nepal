<?php namespace App\Models;

use CodeIgniter\Model;

class Deal extends Model
{
    protected $table = 'deals';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['company_id', 'contact_id', 'title', 'stage', 'value', 'assigned_to', 'created_at', 'updated_at'];
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getByCompany(int $companyId): array
    {
        return $this->where('company_id', $companyId)->findAll();
    }

    public function getByStage(int $companyId, string $stage): array
    {
        return $this->where('company_id', $companyId)->where('stage', $stage)->findAll();
    }

    public function getTotalValue(int $companyId): float
    {
        $result = $this->where('company_id', $companyId)->selectSum('value')->first();
        return (float)($result['value'] ?? 0);
    }
}

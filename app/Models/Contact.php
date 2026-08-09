<?php namespace App\Models;

use CodeIgniter\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['company_id', 'name', 'company_name', 'email', 'phone', 'status', 'value', 'last_contact_date', 'created_at'];
    protected $createdField = 'created_at';

    public function getByCompany(int $companyId): array
    {
        return $this->where('company_id', $companyId)->findAll();
    }

    public function countByCompany(int $companyId): int
    {
        return $this->where('company_id', $companyId)->countAllResults();
    }
}

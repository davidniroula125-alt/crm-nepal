<?php namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['company_id', 'name', 'email', 'password_hash', 'role', 'language', 'created_at'];
    protected $createdField = 'created_at';

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    public function getByCompany(int $companyId): array
    {
        return $this->where('company_id', $companyId)->findAll();
    }
}

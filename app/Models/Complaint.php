<?php namespace App\Models;

use CodeIgniter\Model;

class Complaint extends Model
{
    protected $table = 'support_messages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'email', 'subject', 'message', 'type', 'status', 'reply', 'user_id', 'company_id', 'replied_by', 'replied_at', 'read_at', 'resolved_at', 'closed_at', 'created_at'];
    protected $createdField = 'created_at';

    public function getComplaints(): array
    {
        return $this->where('type', 'complaint')->findAll();
    }

    public function getByCompany(int $companyId): array
    {
        return $this->where('company_id', $companyId)->findAll();
    }
}

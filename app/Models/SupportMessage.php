<?php namespace App\Models;

use CodeIgniter\Model;

class SupportMessage extends Model
{
    protected $table = 'support_messages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'email', 'subject', 'message', 'type', 'status', 'reply', 'user_id', 'company_id', 'replied_by', 'replied_at', 'read_at', 'resolved_at', 'closed_at', 'created_at'];
    protected $createdField = 'created_at';

    public function getInquiries(): array
    {
        return $this->whereIn('type', ['contact', 'chatbot'])->findAll();
    }

    public function getByType(string $type): array
    {
        return $this->where('type', $type)->findAll();
    }

    public function countByType(string $type): int
    {
        return $this->where('type', $type)->countAllResults();
    }

    public function countByStatus(string $type, string $status): int
    {
        return $this->where('type', $type)->where('status', $status)->countAllResults();
    }
}

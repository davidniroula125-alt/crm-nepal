<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactInquiryModel extends Model
{
    protected $table            = 'contact_inquiries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name',
        'company',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'created_at',
    ];

    protected $useTimestamps = false;

    public function countAll(): int
    {
        return $this->countAllResults();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class DemoRequestModel extends Model
{
    protected $table            = 'demo_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'full_name',
        'company_name',
        'email',
        'phone',
        'address',
        'employee_count',
        'current_software',
        'business_type',
        'preferred_date',
        'preferred_time',
        'message',
        'lead_id',
        'status',
        'created_at',
    ];

    protected $useTimestamps = false;

    public function countAll(): int
    {
        return $this->countAllResults();
    }
}

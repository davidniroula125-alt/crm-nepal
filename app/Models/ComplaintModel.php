<?php

namespace App\Models;

use CodeIgniter\Model;

class ComplaintModel extends Model
{
    protected $table            = 'complaints';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'user_id',
        'subject',
        'message',
        'admin_reply',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;
}

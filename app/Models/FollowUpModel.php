<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowUpModel extends Model
{
    protected $table            = 'follow_ups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = '';

    protected $allowedFields = [
        'lead_id',
        'client_id',
        'assigned_to',
        'title',
        'notes',
        'due_at',
        'status',
    ];

    protected $validationRules = [
        'title'  => 'required|max_length[200]',
        'due_at' => 'required',
    ];
}

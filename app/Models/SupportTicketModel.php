<?php

namespace App\Models;

use CodeIgniter\Model;

class SupportTicketModel extends Model
{
    protected $table            = 'support_tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'client_id',
        'subject',
        'description',
        'status',
        'assigned_to',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'subject'      => 'required|max_length[150]',
        'description'  => 'required',
        'status'       => 'required|in_list[Open,In Progress,Resolved,Closed]',
    ];

    protected $validationMessages = [
        'status' => [
            'in_list' => 'Status must be Open, In Progress, Resolved, or Closed.',
        ],
    ];

    public function filterByStatus(string $status): self
    {
        if (empty($status) || ! in_array($status, ['Open', 'In Progress', 'Resolved', 'Closed'], true)) {
            return $this;
        }

        return $this->where('status', $status);
    }

    public function countAllFiltered(string $status): int
    {
        return $this->filterByStatus($status)->countAllResults();
    }
}

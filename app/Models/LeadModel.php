<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model
{
    protected $table            = 'leads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'full_name',
        'company_name',
        'email',
        'phone',
        'source',
        'status',
        'assigned_to',
        'notes',
        'next_follow_up_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'full_name' => 'required|max_length[150]',
        'email'     => 'permit_empty|valid_email',
        'source'    => 'required|in_list[Website,Facebook,Google,Referral,Phone,Email,Exhibition/Event,Existing Customer,Other,Demo Request]',
        'status'    => 'permit_empty|in_list[New,Contacted,Qualified,Converted,Lost]',
    ];

    protected $validationMessages = [
        'full_name' => [
            'required' => 'Full name is required.',
        ],
    ];

    /**
     * Find a lead by ID with assigned user name joined.
     */
    public function findWithUser(int $id): ?object
    {
        return $this->select('leads.*, users.name as assigned_to_name')
            ->join('users', 'users.id = leads.assigned_to', 'left')
            ->where('leads.id', $id)
            ->first();
    }

    /**
     * Get paginated leads with optional search and filters.
     */
    public function getLeadsFiltered(array $filters, int $perPage = 20): array
    {
        $page = max(1, (int) ($filters['page'] ?? 1));

        $builder = $this->select('leads.*, users.name as assigned_to_name')
            ->join('users', 'users.id = leads.assigned_to', 'left');

        // Search by name, email, or company
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                ->like('leads.full_name', $search)
                ->orLike('leads.email', $search)
                ->orLike('leads.company_name', $search)
                ->groupEnd();
        }

        // Filter by status
        if (! empty($filters['status'])) {
            $builder->where('leads.status', $filters['status']);
        }

        // Filter by source
        if (! empty($filters['source'])) {
            $builder->where('leads.source', $filters['source']);
        }

        // Filter by assigned_to
        if (! empty($filters['assigned_to'])) {
            $builder->where('leads.assigned_to', $filters['assigned_to']);
        }

        $builder->orderBy('leads.id', 'DESC');

        $total = $builder->countAllResults(false);
        $leads = $builder->paginate($perPage);

        return [
            'leads'       => $leads,
            'total'       => $total,
            'perPage'     => $perPage,
            'currentPage' => $page,
        ];
    }
}

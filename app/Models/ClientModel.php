<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'lead_id',
        'company_name',
        'contact_name',
        'email',
        'phone',
        'address',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'company_name' => 'required|max_length[255]',
        'contact_name' => 'required|max_length[255]',
        'email'        => 'required|valid_email|max_length[255]',
        'phone'        => 'permit_empty|max_length[50]',
        'address'      => 'permit_empty',
        'lead_id'      => 'permit_empty|is_unique[clients.lead_id,id,{id}]',
        'status'       => 'required|in_list[active,inactive]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already assigned to another client.',
        ],
        'lead_id' => [
            'is_unique' => 'This lead is already linked to another client.',
        ],
    ];

    public function searchByName(string $search): self
    {
        if (empty($search)) {
            return $this;
        }

        $escaped = '%' . $this->db->escapeString($search) . '%';

        return $this->groupStart()
            ->like('contact_name', $escaped)
            ->orLike('company_name', $escaped)
            ->orLike('email', $escaped)
            ->groupEnd();
    }

    public function filterByStatus(string $status): self
    {
        if (empty($status) || ! in_array($status, ['active', 'inactive'], true)) {
            return $this;
        }

        return $this->where('status', $status);
    }

    public function countAllFiltered(string $search, string $status): int
    {
        return $this->searchByName($search)->filterByStatus($status)->countAllResults();
    }
}

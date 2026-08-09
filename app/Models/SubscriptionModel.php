<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{
    protected $table            = 'subscriptions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'client_id',
        'plan_name',
        'billing_cycle',
        'amount',
        'start_date',
        'end_date',
        'status',
        'created_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'client_id'     => 'required|integer',
        'plan_name'     => 'required|max_length[255]',
        'billing_cycle' => 'required|in_list[monthly,annual]',
        'amount'        => 'required|decimal',
        'start_date'    => 'required',
        'end_date'      => 'permit_empty',
        'status'        => 'required|in_list[active,expiring,expired,cancelled]',
    ];

    public function searchByClient(string $search): self
    {
        if (empty($search)) {
            return $this;
        }

        $escaped = '%' . $this->db->escapeString($search) . '%';

        return $this->join('clients', 'clients.id = subscriptions.client_id', 'left')
            ->groupStart()
            ->like('clients.contact_name', $escaped)
            ->orLike('clients.company_name', $escaped)
            ->orLike('clients.email', $escaped)
            ->orLike('subscriptions.plan_name', $escaped)
            ->groupEnd();
    }

    public function filterByStatus(string $status): self
    {
        if (empty($status) || ! in_array($status, ['active', 'expiring', 'expired', 'cancelled'], true)) {
            return $this;
        }

        return $this->where('subscriptions.status', $status);
    }

    public function countAllFiltered(string $search, string $status): int
    {
        return $this->searchByClient($search)->filterByStatus($status)->countAllResults();
    }

    public function getClientName(int $clientId): string
    {
        $client = (new ClientModel())->find($clientId);

        return $client ? $client->contact_name : 'Unknown';
    }
}

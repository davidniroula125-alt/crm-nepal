<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'client_id',
        'subscription_id',
        'amount',
        'status',
        'paid_at',
        'due_date',
        'method',
        'notes',
        'created_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'client_id'   => 'required|integer',
        'amount'      => 'required|decimal|greater_than[0]',
        'status'      => 'required|in_list[Paid,Pending,Overdue,Partial]',
        'due_date'    => 'permit_empty',
        'method'      => 'permit_empty',
        'notes'       => 'permit_empty',
    ];

    public function searchByClient(string $search): self
    {
        if (empty($search)) {
            return $this;
        }

        return $this->groupStart()
            ->join('clients', 'clients.id = payments.client_id', 'left')
            ->like('clients.company_name', $search)
            ->orLike('clients.contact_name', $search)
            ->groupEnd();
    }

    public function filterByStatus(string $status): self
    {
        if (empty($status) || ! in_array($status, ['Paid', 'Pending', 'Overdue', 'Partial'], true)) {
            return $this;
        }

        return $this->where('payments.status', $status);
    }

    public function countAllFiltered(string $search, string $status): int
    {
        return $this->searchByClient($search)->filterByStatus($status)->countAllResults();
    }

    public function getNextInvoiceNumber(): string
    {
        $year = date('Y');
        $db = \Config\Database::connect();
        $builder = $db->table('invoices');
        $builder->like('invoice_number', "INV-{$year}-", 'after');
        $count = $builder->countAllResults(false);

        return sprintf('INV-%s-%04d', $year, $count + 1);
    }
}

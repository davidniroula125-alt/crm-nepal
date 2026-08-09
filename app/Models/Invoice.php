<?php namespace App\Models;

use CodeIgniter\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['company_id', 'contact_id', 'invoice_number', 'amount', 'vat_amount', 'payment_method', 'status', 'due_date', 'created_at'];
    protected $createdField = 'created_at';

    public function getByCompany(int $companyId): array
    {
        return $this->where('company_id', $companyId)->findAll();
    }

    public function generateNumber(int $companyId): string
    {
        $count = $this->where('company_id', $companyId)->countAllResults();
        return 'INV-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}

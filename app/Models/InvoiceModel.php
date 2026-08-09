<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'invoices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'payment_id',
        'invoice_number',
        'issued_at',
        'pdf_path',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'payment_id'     => 'required|integer',
        'invoice_number' => 'required|max_length[50]|is_unique[invoices.invoice_number,id,{id}]',
    ];
}

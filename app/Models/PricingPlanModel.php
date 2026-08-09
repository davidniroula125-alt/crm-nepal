<?php

namespace App\Models;

use CodeIgniter\Model;

class PricingPlanModel extends Model
{
    protected $table            = 'pricing_plans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name',
        'description',
        'price_monthly',
        'price_annual',
        'status',
        'created_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'name'          => 'required|max_length[255]',
        'description'   => 'permit_empty',
        'price_monthly' => 'required|decimal',
        'price_annual'  => 'permit_empty|decimal',
        'status'        => 'required|in_list[active,inactive]',
    ];

    public function getActivePlans(): array
    {
        return $this->where('status', 'active')->orderBy('name', 'ASC')->findAll();
    }
}

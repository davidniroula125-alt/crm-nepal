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
        'billing_cycle',
        'price',
        'description',
        'features',
        'is_active',
        'sort_order',
        'created_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'name'          => 'required|max_length[255]',
        'billing_cycle' => 'required|in_list[Monthly,Annual]',
        'price'         => 'required|decimal',
        'description'   => 'permit_empty',
        'features'      => 'permit_empty',
        'is_active'     => 'required|in_list[0,1]',
    ];

    public function getActivePlans(): array
    {
        return $this->where('is_active', 1)
            ->where('billing_cycle', 'Monthly')
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }
}

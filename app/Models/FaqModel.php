<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table            = 'faqs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'category',
        'question',
        'answer',
        'sort_order',
        'is_published',
        'created_at',
    ];

    protected $useTimestamps = false;

    public function countAll(): int
    {
        return $this->countAllResults();
    }

    public function filterByCategory(string $category): self
    {
        if (empty($category)) {
            return $this;
        }

        return $this->where('category', $category);
    }
}

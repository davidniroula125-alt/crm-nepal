<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogCategoryModel extends Model
{
    protected $table            = 'blog_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name',
        'slug',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'name' => 'required|max_length[150]',
        'slug' => 'required|max_length[150]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Category name is required.',
        ],
    ];

    /**
     * Check slug uniqueness excluding a given ID.
     */
    public function isSlugUnique(string $slug, int $excludeId = 0): bool
    {
        $builder = $this->where('slug', $slug);
        if ($excludeId > 0) {
            $builder->where('id !=', $excludeId);
        }
        return $builder->countAllResults() === 0;
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table            = 'testimonials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'client_name',
        'company',
        'designation',
        'profile_image',
        'testimonial_text',
        'star_rating',
        'is_published',
        'sort_order',
        'created_at',
    ];

    protected $useTimestamps = false;

    public function countAll(): int
    {
        return $this->countAllResults();
    }

    public function filterByPublished($published): self
    {
        if ($published === null || $published === '') {
            return $this;
        }

        return $this->where('is_published', (int) $published);
    }
}

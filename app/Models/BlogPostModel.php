<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostModel extends Model
{
    protected $table            = 'blog_posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'featured_image',
        'excerpt',
        'body',
        'tags',
        'seo_title',
        'meta_description',
        'status',
        'published_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'title'    => 'required|max_length[255]',
        'slug'     => 'required|max_length[255]',
        'category_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Title is required.',
        ],
        'slug' => [
            'required' => 'Slug is required.',
        ],
    ];

    /**
     * Get paginated posts with optional filters.
     */
    public function getPostsFiltered(array $filters, int $perPage = 20): array
    {
        $builder = $this->select('blog_posts.*, users.name as author_name, blog_categories.name as category_name')
            ->join('users', 'users.id = blog_posts.author_id', 'left')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                ->like('blog_posts.title', $search)
                ->groupEnd();
        }

        if (! empty($filters['status'])) {
            $builder->where('blog_posts.status', $filters['status']);
        }

        $total = $builder->countAllResults(false);
        $posts = $builder->orderBy('blog_posts.id', 'DESC')
            ->limit($perPage, ($filters['page'] - 1) * $perPage)
            ->get()
            ->getResult();

        return [
            'posts'       => $posts,
            'total'       => $total,
            'perPage'     => $perPage,
            'currentPage' => $filters['page'],
        ];
    }

    /**
     * Find a post by ID with author and category joined.
     */
    public function findWithRelations(int $id): ?object
    {
        return $this->select('blog_posts.*, users.name as author_name, blog_categories.name as category_name')
            ->join('users', 'users.id = blog_posts.author_id', 'left')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->find($id);
    }

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

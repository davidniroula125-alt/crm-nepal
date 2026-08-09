<?php

namespace App\Controllers\Admin;

use App\Models\BlogPostModel;
use App\Models\BlogCategoryModel;

class Blog extends BaseController
{
    protected $postModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->postModel     = new BlogPostModel();
        $this->categoryModel = new BlogCategoryModel();
    }

    /**
     * List blog posts with status filter and search. Paginate 20/page.
     */
    public function index()
    {
        $page = max(1, (int) ($this->request->getVar('page') ?? 1));

        $filters = [
            'search' => $this->request->getVar('search') ?? '',
            'status' => $this->request->getVar('status') ?? '',
            'page'   => $page,
        ];

        $data = $this->postModel->getPostsFiltered($filters, 20);

        return view('admin/blog/index', [
            'pageTitle'   => 'Blog Posts',
            'posts'       => $data['posts'],
            'total'       => $data['total'],
            'perPage'     => $data['perPage'],
            'currentPage' => $data['currentPage'],
            'filters'     => $filters,
        ]);
    }

    /**
     * Show create form. Get categories for dropdown.
     */
    public function create()
    {
        $categories = $this->categoryModel->orderBy('name', 'ASC')->findAll();

        return view('admin/blog/create', [
            'pageTitle'  => 'Create Blog Post',
            'categories' => $categories,
            'statuses'   => ['Draft', 'Published'],
        ]);
    }

    /**
     * Validate and save new blog post. Auto-generate slug from title.
     */
    public function store()
    {
        $rules = [
            'title'            => 'required|max_length[255]',
            'category_id'      => 'required|integer',
            'featured_image'   => 'permit_empty|max_length[255]',
            'excerpt'          => 'permit_empty',
            'body'             => 'permit_empty',
            'tags'             => 'permit_empty|max_length[500]',
            'seo_title'        => 'permit_empty|max_length[255]',
            'meta_description' => 'permit_empty|max_length[500]',
            'status'           => 'permit_empty|in_list[Draft,Published]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $title = $this->request->getPost('title');
        $slug  = url_title($title, '-', true);

        // Ensure slug uniqueness
        $originalSlug = $slug;
        $counter      = 1;
        while (! $this->postModel->isSlugUnique($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $status       = $this->request->getPost('status') ?: 'Draft';
        $publishedAt  = $status === 'Published' ? date('Y-m-d H:i:s') : null;

        $postData = [
            'category_id'      => $this->request->getPost('category_id'),
            'author_id'        => session()->get('user_id'),
            'title'            => $title,
            'slug'             => $slug,
            'featured_image'   => $this->request->getPost('featured_image'),
            'excerpt'          => $this->request->getPost('excerpt'),
            'body'             => $this->request->getPost('body'),
            'tags'             => $this->request->getPost('tags'),
            'seo_title'        => $this->request->getPost('seo_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'status'           => $status,
            'published_at'     => $publishedAt,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        $postId = $this->postModel->insert($postData);

        if ($postId) {
            return redirect()->to('/admin/blog')
                ->with('success', 'Blog post created successfully.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create blog post. Please try again.');
    }

    /**
     * Show single post details.
     */
    public function show($id = null)
    {
        $post = $this->postModel->findWithRelations((int) $id);

        if (! $post) {
            return redirect()->to('/admin/blog')
                ->with('error', 'Blog post not found.');
        }

        return view('admin/blog/show', [
            'pageTitle' => 'Blog Post Details',
            'post'      => $post,
        ]);
    }

    /**
     * Show edit form pre-filled with post data.
     */
    public function edit($id = null)
    {
        $post = $this->postModel->find((int) $id);

        if (! $post) {
            return redirect()->to('/admin/blog')
                ->with('error', 'Blog post not found.');
        }

        $categories = $this->categoryModel->orderBy('name', 'ASC')->findAll();

        return view('admin/blog/edit', [
            'pageTitle'  => 'Edit Blog Post',
            'post'       => $post,
            'categories' => $categories,
            'statuses'   => ['Draft', 'Published'],
        ]);
    }

    /**
     * Validate and update blog post.
     */
    public function update($id = null)
    {
        $post = $this->postModel->find((int) $id);

        if (! $post) {
            return redirect()->to('/admin/blog')
                ->with('error', 'Blog post not found.');
        }

        $rules = [
            'title'            => 'required|max_length[255]',
            'category_id'      => 'required|integer',
            'featured_image'   => 'permit_empty|max_length[255]',
            'excerpt'          => 'permit_empty',
            'body'             => 'permit_empty',
            'tags'             => 'permit_empty|max_length[500]',
            'seo_title'        => 'permit_empty|max_length[255]',
            'meta_description' => 'permit_empty|max_length[500]',
            'status'           => 'permit_empty|in_list[Draft,Published]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $title = $this->request->getPost('title');
        $slug  = url_title($title, '-', true);

        // Ensure slug uniqueness excluding current post
        $originalSlug = $slug;
        $counter      = 1;
        while (! $this->postModel->isSlugUnique($slug, (int) $id)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $status      = $this->request->getPost('status') ?: $post->status;
        $publishedAt = $post->published_at;
        if ($status === 'Published' && $post->status !== 'Published') {
            $publishedAt = date('Y-m-d H:i:s');
        } elseif ($status !== 'Published') {
            $publishedAt = null;
        }

        $postData = [
            'category_id'      => $this->request->getPost('category_id'),
            'title'            => $title,
            'slug'             => $slug,
            'featured_image'   => $this->request->getPost('featured_image'),
            'excerpt'          => $this->request->getPost('excerpt'),
            'body'             => $this->request->getPost('body'),
            'tags'             => $this->request->getPost('tags'),
            'seo_title'        => $this->request->getPost('seo_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'status'           => $status,
            'published_at'     => $publishedAt,
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        $updated = $this->postModel->update((int) $id, $postData);

        if ($updated) {
            return redirect()->to('/admin/blog/' . $id)
                ->with('success', 'Blog post updated successfully.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update blog post. Please try again.');
    }

    /**
     * Delete blog post and redirect back.
     */
    public function delete($id = null)
    {
        $post = $this->postModel->find((int) $id);

        if (! $post) {
            return redirect()->to('/admin/blog')
                ->with('error', 'Blog post not found.');
        }

        $deleted = $this->postModel->delete((int) $id);

        if ($deleted) {
            return redirect()->to('/admin/blog')
                ->with('success', 'Blog post deleted successfully.');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete blog post. Please try again.');
    }

    /**
     * Set post status to Published and set published_at to now.
     */
    public function publish($id = null)
    {
        $post = $this->postModel->find((int) $id);

        if (! $post) {
            return redirect()->to('/admin/blog')
                ->with('error', 'Blog post not found.');
        }

        $this->postModel->update((int) $id, [
            'status'       => 'Published',
            'published_at' => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()
            ->with('success', 'Blog post published successfully.');
    }

    /**
     * Set post status to Draft and clear published_at.
     */
    public function unpublish($id = null)
    {
        $post = $this->postModel->find((int) $id);

        if (! $post) {
            return redirect()->to('/admin/blog')
                ->with('error', 'Blog post not found.');
        }

        $this->postModel->update((int) $id, [
            'status'       => 'Draft',
            'published_at' => null,
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()
            ->with('success', 'Blog post unpublished successfully.');
    }
}

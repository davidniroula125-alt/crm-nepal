<?php

namespace App\Controllers;

use App\Models\BlogPostModel;

class Blog extends BaseController
{
    public function index(): string
    {
        $model = model(BlogPostModel::class);

        $page = (int) ($this->request->getVar('page') ?? 1);
        $perPage = 9;

        $data = $model->getPostsFiltered([
            'status' => 'published',
            'page'   => $page,
        ], $perPage);

        $categories = model(\App\Models\BlogCategoryModel::class)->findAll();

        return view('pages/blog_index', $this->siteData(array_merge($data, [
            'metaTitle'  => 'Blog | CRM Software Nepal',
            'categories' => $categories,
            'perPage'    => $perPage,
        ])));
    }

    public function show(string $slug): string
    {
        $model = model(BlogPostModel::class);

        $post = $model->select('blog_posts.*, users.name as author_name, blog_categories.name as category_name, blog_categories.slug as category_slug')
            ->join('users', 'users.id = blog_posts.author_id', 'left')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where('blog_posts.slug', $slug)
            ->where('blog_posts.status', 'published')
            ->first();

        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog post not found.");
        }

        // Related posts from same category
        $related = $model->select('blog_posts.title, blog_posts.slug, blog_posts.excerpt, blog_posts.published_at, blog_categories.name as category_name')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where('blog_posts.category_id', $post->category_id)
            ->where('blog_posts.id !=', $post->id)
            ->where('blog_posts.status', 'published')
            ->orderBy('blog_posts.published_at', 'DESC')
            ->limit(3)
            ->get()
            ->getResult();

        return view('pages/blog_show', $this->siteData([
            'metaTitle'     => esc($post->seo_title ?: $post->title) . ' | CRM Software Nepal',
            'post'          => $post,
            'related'       => $related,
        ]));
    }

    public function category(string $slug): string
    {
        $categoryModel = model(\App\Models\BlogCategoryModel::class);
        $category = $categoryModel->where('slug', $slug)->first();

        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog category not found.");
        }

        $model = model(BlogPostModel::class);
        $page = (int) ($this->request->getVar('page') ?? 1);
        $perPage = 9;

        $builder = $model->select('blog_posts.*, users.name as author_name, blog_categories.name as category_name')
            ->join('users', 'users.id = blog_posts.author_id', 'left')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where('blog_posts.category_id', $category->id)
            ->where('blog_posts.status', 'published')
            ->orderBy('blog_posts.published_at', 'DESC');

        $total = $builder->countAllResults(false);
        $posts = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResult();

        $categories = $categoryModel->findAll();

        return view('pages/blog_index', $this->siteData([
            'metaTitle'       => esc($category->name) . ' | Blog | CRM Software Nepal',
            'posts'           => $posts,
            'total'           => $total,
            'perPage'         => $perPage,
            'currentPage'     => $page,
            'categories'      => $categories,
            'activeCategory'  => $category,
        ]));
    }
}

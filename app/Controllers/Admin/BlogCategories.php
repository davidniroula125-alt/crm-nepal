<?php

namespace App\Controllers\Admin;

use App\Models\BlogCategoryModel;

class BlogCategories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new BlogCategoryModel();
    }

    /**
     * List all categories.
     */
    public function index()
    {
        $categories = $this->categoryModel->orderBy('name', 'ASC')->findAll();

        return view('admin/blog/categories', [
            'pageTitle'  => 'Blog Categories',
            'categories' => $categories,
        ]);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin/blog/category_create', [
            'pageTitle' => 'Create Blog Category',
        ]);
    }

    /**
     * Validate and save new category.
     */
    public function store()
    {
        $rules = [
            'name' => 'required|max_length[150]',
            'slug' => 'required|max_length[150]|is_unique[blog_categories.slug]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $categoryData = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
        ];

        $categoryId = $this->categoryModel->insert($categoryData);

        if ($categoryId) {
            return redirect()->to('/admin/blog/categories')
                ->with('success', 'Category created successfully.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create category. Please try again.');
    }

    /**
     * Show edit form pre-filled with category data.
     */
    public function edit($id = null)
    {
        $category = $this->categoryModel->find((int) $id);

        if (! $category) {
            return redirect()->to('/admin/blog/categories')
                ->with('error', 'Category not found.');
        }

        return view('admin/blog/category_edit', [
            'pageTitle' => 'Edit Blog Category',
            'category'  => $category,
        ]);
    }

    /**
     * Validate and update category.
     */
    public function update($id = null)
    {
        $category = $this->categoryModel->find((int) $id);

        if (! $category) {
            return redirect()->to('/admin/blog/categories')
                ->with('error', 'Category not found.');
        }

        $rules = [
            'name' => 'required|max_length[150]',
            'slug' => "required|max_length[150]|is_unique[blog_categories.slug,id,{$id}]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $categoryData = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
        ];

        $updated = $this->categoryModel->update((int) $id, $categoryData);

        if ($updated) {
            return redirect()->to('/admin/blog/categories')
                ->with('success', 'Category updated successfully.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update category. Please try again.');
    }

    /**
     * Delete category and redirect back.
     */
    public function delete($id = null)
    {
        $category = $this->categoryModel->find((int) $id);

        if (! $category) {
            return redirect()->to('/admin/blog/categories')
                ->with('error', 'Category not found.');
        }

        $deleted = $this->categoryModel->delete((int) $id);

        if ($deleted) {
            return redirect()->to('/admin/blog/categories')
                ->with('success', 'Category deleted successfully.');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete category. Please try again.');
    }
}

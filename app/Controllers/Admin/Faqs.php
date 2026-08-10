<?php

namespace App\Controllers\Admin;

use App\Models\FaqModel;

class Faqs extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new FaqModel();
    }

    public function index()
    {
        $category = $this->request->getGet('category');

        $builder = $this->model->orderBy('sort_order', 'ASC')->orderBy('id', 'DESC');

        if ($category !== null && $category !== '') {
            $builder = $builder->where('category', $category);
        }

        $data = [];
        $data['faqs']            = $builder->paginate(20);
        $data['pager']           = $this->model->pager;
        $data['total']           = $builder->countAllResults(false);
        $data['currentCategory'] = $category ?? '';

        return view('admin/faqs/index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'Add New FAQ',
        ];

        return view('admin/faqs/create', $data);
    }

    public function store()
    {
        $rules = [
            'category'  => 'required|max_length[100]',
            'question'  => 'required|max_length[500]',
            'answer'    => 'required',
            'sort_order' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'category'    => $this->request->getPost('category'),
            'question'    => $this->request->getPost('question'),
            'answer'      => $this->request->getPost('answer'),
            'sort_order'  => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        if (! $this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', $this->model->errors()
                ? implode('<br>', $this->model->errors())
                : 'Failed to create FAQ.');
        }

        return redirect()->to('/admin/faqs')->with('success', 'FAQ created successfully.');
    }

    public function show($id)
    {
        $faq = $this->model->find($id);

        if (! $faq) {
            return redirect()->to('/admin/faqs')->with('error', 'FAQ not found.');
        }

        $data = [
            'pageTitle' => 'FAQ Details',
            'faq'       => $faq,
        ];

        return view('admin/faqs/show', $data);
    }

    public function edit($id)
    {
        $faq = $this->model->find($id);

        if (! $faq) {
            return redirect()->to('/admin/faqs')->with('error', 'FAQ not found.');
        }

        $data = [
            'pageTitle' => 'Edit FAQ',
            'faq'       => $faq,
        ];

        return view('admin/faqs/edit', $data);
    }

    public function update($id)
    {
        $faq = $this->model->find($id);

        if (! $faq) {
            return redirect()->to('/admin/faqs')->with('error', 'FAQ not found.');
        }

        $rules = [
            'category'  => 'required|max_length[100]',
            'question'  => 'required|max_length[500]',
            'answer'    => 'required',
            'sort_order' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'category'    => $this->request->getPost('category'),
            'question'    => $this->request->getPost('question'),
            'answer'      => $this->request->getPost('answer'),
            'sort_order'  => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
        ];

        if (! $this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', $this->model->errors()
                ? implode('<br>', $this->model->errors())
                : 'Failed to update FAQ.');
        }

        return redirect()->to("/admin/faqs/{$id}/edit")->with('success', 'FAQ updated successfully.');
    }

    public function delete($id)
    {
        $faq = $this->model->find($id);

        if (! $faq) {
            return redirect()->to('/admin/faqs')->with('error', 'FAQ not found.');
        }

        $this->model->delete($id);

        return redirect()->to('/admin/faqs')->with('success', 'FAQ deleted successfully.');
    }

    public function togglePublish($id)
    {
        $faq = $this->model->find($id);

        if (! $faq) {
            return redirect()->to('/admin/faqs')->with('error', 'FAQ not found.');
        }

        $this->model->update($id, ['is_published' => $faq->is_published ? 0 : 1]);

        return redirect()->back()->with('success', 'FAQ publish status updated.');
    }
}

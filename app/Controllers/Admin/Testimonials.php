<?php

namespace App\Controllers\Admin;

use App\Models\TestimonialModel;

class Testimonials extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TestimonialModel();
    }

    public function index()
    {
        $published = $this->request->getGet('published');

        $builder = $this->model->orderBy('sort_order', 'ASC')->orderBy('id', 'DESC');

        if ($published !== null && $published !== '') {
            $builder = $builder->where('is_published', (int) $published);
        }

        $data = [];
        $data['testimonials']    = $builder->paginate(20);
        $data['pager']           = $this->model->pager;
        $data['total']           = $builder->countAllResults(false);
        $data['currentPublished'] = $published ?? '';

        return view('admin/testimonials/index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'Add New Testimonial',
        ];

        return view('admin/testimonials/create', $data);
    }

    public function store()
    {
        $rules = [
            'client_name'       => 'required|max_length[255]',
            'company'           => 'permit_empty|max_length[255]',
            'designation'       => 'permit_empty|max_length[255]',
            'profile_image'     => 'permit_empty|max_length[500]',
            'testimonial_text'  => 'required',
            'star_rating'       => 'required|integer|in_list[1,2,3,4,5]',
            'sort_order'        => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'client_name'      => $this->request->getPost('client_name'),
            'company'          => $this->request->getPost('company'),
            'designation'      => $this->request->getPost('designation'),
            'profile_image'    => $this->request->getPost('profile_image'),
            'testimonial_text' => $this->request->getPost('testimonial_text'),
            'star_rating'      => (int) $this->request->getPost('star_rating'),
            'is_published'     => $this->request->getPost('is_published') ? 1 : 0,
            'sort_order'       => (int) ($this->request->getPost('sort_order') ?? 0),
            'created_at'       => date('Y-m-d H:i:s'),
        ];

        if (! $this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', $this->model->errors()
                ? implode('<br>', $this->model->errors())
                : 'Failed to create testimonial.');
        }

        return redirect()->to('/admin/testimonials')->with('success', 'Testimonial created successfully.');
    }

    public function show($id)
    {
        $testimonial = $this->model->find($id);

        if (! $testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found.');
        }

        $data = [
            'pageTitle'   => 'Testimonial Details',
            'testimonial' => $testimonial,
        ];

        return view('admin/testimonials/show', $data);
    }

    public function edit($id)
    {
        $testimonial = $this->model->find($id);

        if (! $testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found.');
        }

        $data = [
            'pageTitle'   => 'Edit Testimonial',
            'testimonial' => $testimonial,
        ];

        return view('admin/testimonials/edit', $data);
    }

    public function update($id)
    {
        $testimonial = $this->model->find($id);

        if (! $testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found.');
        }

        $rules = [
            'client_name'       => 'required|max_length[255]',
            'company'           => 'permit_empty|max_length[255]',
            'designation'       => 'permit_empty|max_length[255]',
            'profile_image'     => 'permit_empty|max_length[500]',
            'testimonial_text'  => 'required',
            'star_rating'       => 'required|integer|in_list[1,2,3,4,5]',
            'sort_order'        => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'client_name'      => $this->request->getPost('client_name'),
            'company'          => $this->request->getPost('company'),
            'designation'      => $this->request->getPost('designation'),
            'profile_image'    => $this->request->getPost('profile_image'),
            'testimonial_text' => $this->request->getPost('testimonial_text'),
            'star_rating'      => (int) $this->request->getPost('star_rating'),
            'is_published'     => $this->request->getPost('is_published') ? 1 : 0,
            'sort_order'       => (int) ($this->request->getPost('sort_order') ?? 0),
        ];

        if (! $this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', $this->model->errors()
                ? implode('<br>', $this->model->errors())
                : 'Failed to update testimonial.');
        }

        return redirect()->to("/admin/testimonials/{$id}/edit")->with('success', 'Testimonial updated successfully.');
    }

    public function delete($id)
    {
        $testimonial = $this->model->find($id);

        if (! $testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found.');
        }

        $this->model->delete($id);

        return redirect()->to('/admin/testimonials')->with('success', 'Testimonial deleted successfully.');
    }

    public function togglePublish($id)
    {
        $testimonial = $this->model->find($id);

        if (! $testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found.');
        }

        $this->model->update($id, ['is_published' => $testimonial->is_published ? 0 : 1]);

        return redirect()->back()->with('success', 'Testimonial publish status updated.');
    }

    public function reorder($id)
    {
        $testimonial = $this->model->find($id);

        if (! $testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimonial not found.');
        }

        $sortOrder = (int) $this->request->getPost('sort_order');

        $this->model->update($id, ['sort_order' => $sortOrder]);

        return redirect()->back()->with('success', 'Testimonial sort order updated.');
    }
}

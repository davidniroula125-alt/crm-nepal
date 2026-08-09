<?php

namespace App\Controllers\Admin;

use App\Models\ContactInquiryModel;

class ContactInquiries extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new ContactInquiryModel();
    }

    public function index()
    {
        $this->requireAdmin();

        $builder = $this->model->builder();
        $builder->orderBy('created_at', 'DESC');

        $status = $this->request->getGet('status');
        if ($status !== null && $status !== '') {
            $builder->where('status', $status);
        }

        $data['inquiries'] = $builder->paginate(20);
        $data['pager']     = $this->model->pager;
        $data['total']     = $this->model->countAll();
        $data['currentStatus'] = $status ?? '';

        return view('admin/contact_inquiries/index', $data);
    }

    public function show($id)
    {
        $this->requireAdmin();

        $inquiry = $this->model->find($id);

        if (! $inquiry) {
            return redirect()->back()->with('error', 'Inquiry not found.');
        }

        if ($inquiry->status === 'New') {
            $this->model->update($id, ['status' => 'Read']);
        }

        $data['inquiry'] = $this->model->find($id);

        return view('admin/contact_inquiries/show', $data);
    }

    public function updateStatus($id)
    {
        $this->requireAdmin();

        $inquiry = $this->model->find($id);

        if (! $inquiry) {
            return redirect()->back()->with('error', 'Inquiry not found.');
        }

        $status = $this->request->getPost('status');
        $allowed = ['New', 'Read', 'Responded'];

        if (! in_array($status, $allowed)) {
            return redirect()->back()->with('error', 'Invalid status value.');
        }

        $this->model->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function delete($id)
    {
        $this->requireAdmin();

        $inquiry = $this->model->find($id);

        if (! $inquiry) {
            return redirect()->back()->with('error', 'Inquiry not found.');
        }

        $this->model->delete($id);

        return redirect()->back()->with('success', 'Inquiry deleted successfully.');
    }
}

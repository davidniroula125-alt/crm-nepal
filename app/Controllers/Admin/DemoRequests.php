<?php

namespace App\Controllers\Admin;

use App\Models\DemoRequestModel;

class DemoRequests extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DemoRequestModel();
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

        $data['demoRequests'] = $builder->paginate(20);
        $data['pager']        = $this->model->pager;
        $data['total']        = $this->model->countAll();
        $data['currentStatus'] = $status ?? '';

        return view('admin/demo_requests/index', $data);
    }

    public function show($id)
    {
        $this->requireAdmin();

        $data['demoRequest'] = $this->model->find($id);

        if (! $data['demoRequest']) {
            return redirect()->back()->with('error', 'Demo request not found.');
        }

        return view('admin/demo_requests/show', $data);
    }

    public function updateStatus($id)
    {
        $this->requireAdmin();

        $demoRequest = $this->model->find($id);

        if (! $demoRequest) {
            return redirect()->back()->with('error', 'Demo request not found.');
        }

        $status = $this->request->getPost('status');
        $allowed = ['Pending', 'Scheduled', 'Completed', 'Cancelled'];

        if (! in_array($status, $allowed)) {
            return redirect()->back()->with('error', 'Invalid status value.');
        }

        $this->model->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function delete($id)
    {
        $this->requireAdmin();

        $demoRequest = $this->model->find($id);

        if (! $demoRequest) {
            return redirect()->back()->with('error', 'Demo request not found.');
        }

        $this->model->delete($id);

        return redirect()->back()->with('success', 'Demo request deleted successfully.');
    }
}

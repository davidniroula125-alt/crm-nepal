<?php

namespace App\Controllers\Admin;

use App\Models\ComplaintModel;
use App\Models\UserModel;

class Complaints extends BaseController
{
    protected $complaintModel;
    protected $userModel;

    public function __construct()
    {
        $this->complaintModel = new ComplaintModel();
        $this->userModel      = new UserModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status');

        $builder = $this->complaintModel->builder();
        $builder->select('complaints.*, users.name as user_name, users.email as user_email');
        $builder->join('users', 'users.id = complaints.user_id', 'left');

        if ($status) {
            $builder->where('complaints.status', $status);
        }

        $builder->orderBy('complaints.created_at', 'DESC');

        return view('admin/complaints/index', [
            'complaints' => $builder->get()->getResult(),
            'status'     => $status,
        ]);
    }

    public function show($id)
    {
        $builder = $this->complaintModel->builder();
        $builder->select('complaints.*, users.name as user_name, users.email as user_email');
        $builder->join('users', 'users.id = complaints.user_id', 'left');
        $builder->where('complaints.id', $id);
        $complaint = $builder->get()->getRow();

        if (! $complaint) {
            return redirect()->to('/admin/complaints')->with('error', 'Complaint not found.');
        }

        return view('admin/complaints/show', ['complaint' => $complaint]);
    }

    public function reply($id)
    {
        $reply = $this->request->getPost('admin_reply');
        $this->complaintModel->update($id, [
            'admin_reply' => $reply,
            'replied_at'  => date('Y-m-d H:i:s'),
            'status'      => 'Replied',
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to("/admin/complaints/{$id}")->with('success', 'Reply sent.');
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $this->complaintModel->update($id, [
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Status updated.');
    }
}

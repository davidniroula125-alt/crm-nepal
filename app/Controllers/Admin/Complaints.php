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
        try {
            $status = $this->request->getGet('status');

            $this->complaintModel->select('complaints.*, users.name as user_name, users.email as user_email');
            $this->complaintModel->join('users', 'users.id = complaints.user_id', 'left');

            if ($status) {
                $this->complaintModel->where('complaints.status', $status);
            }

            $this->complaintModel->orderBy('complaints.created_at', 'DESC');

            $data = [];
            $data['complaints'] = $this->complaintModel->paginate(20);
            $data['pager']      = $this->complaintModel->pager;
            $data['status']     = $status;

            return view('admin/complaints/index', $data);
        } catch (\Throwable $e) {
            log_message('error', 'Complaints index error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return $this->response->setStatusCode(500)->setBody('Complaints Error: ' . esc($e->getMessage()) . ' in ' . esc($e->getFile()) . ':' . $e->getLine())->setHeader('Content-Type', 'text/plain');
        }
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
        $complaint = $this->complaintModel->find($id);
        if (! $complaint) {
            return redirect()->to('/admin/complaints')->with('error', 'Complaint not found.');
        }

        $reply = $this->request->getPost('admin_reply');
        if (empty(trim($reply))) {
            return redirect()->back()->with('error', 'Reply cannot be empty.');
        }

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
        $complaint = $this->complaintModel->find($id);
        if (! $complaint) {
            return redirect()->to('/admin/complaints')->with('error', 'Complaint not found.');
        }

        $status = $this->request->getPost('status');
        $allowed = ['Open', 'In Progress', 'Replied', 'Closed'];

        if (! in_array($status, $allowed)) {
            return redirect()->back()->with('error', 'Invalid status value.');
        }

        $this->complaintModel->update($id, [
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Status updated.');
    }
}

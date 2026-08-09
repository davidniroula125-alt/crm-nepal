<?php namespace App\Controllers;

use App\Models\SupportMessage;

class Complaints extends BaseController
{
    public function index()
    {
        $supportModel = new SupportMessage();
        $complaints = $supportModel->where('type', 'complaint')->orderBy('created_at', 'DESC')->findAll();
        
        return view('pages/complaints', ['complaints' => $complaints]);
    }

    public function store()
    {
        $supportModel = new SupportMessage();
        
        $supportModel->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
            'type' => 'complaint',
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('complaint_submitted', 'support_message');
        
        return redirect()->to('/complaints')->with('success', 'Complaint submitted successfully');
    }

    public function reply($id)
    {
        $supportModel = new SupportMessage();
        $reply = $this->request->getPost('reply');
        
        $supportModel->update($id, [
            'reply' => $reply,
            'status' => 'replied',
            'replied_by' => $this->session->get('user_id'),
            'replied_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('complaint_replied', 'support_message', $id);
        
        return redirect()->to('/complaints');
    }

    public function updateStatus($id)
    {
        $supportModel = new SupportMessage();
        $status = $this->request->getPost('status');
        
        $updateData = ['status' => $status];
        if ($status === 'read') $updateData['read_at'] = date('Y-m-d H:i:s');
        if ($status === 'resolved') $updateData['resolved_at'] = date('Y-m-d H:i:s');
        if ($status === 'closed') $updateData['closed_at'] = date('Y-m-d H:i:s');
        
        $supportModel->update($id, $updateData);
        
        return redirect()->to('/complaints');
    }
}

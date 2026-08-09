<?php namespace App\Controllers;

use App\Models\SupportMessage;

class Inquiries extends BaseController
{
    public function index()
    {
        $supportModel = new SupportMessage();
        $inquiries = $supportModel->whereIn('type', ['contact', 'chatbot'])->orderBy('created_at', 'DESC')->findAll();
        
        return view('pages/inquiries', ['inquiries' => $inquiries]);
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
        
        log_activity('inquiry_replied', 'support_message', $id);
        
        return redirect()->to('/inquiries');
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
        
        return redirect()->to('/inquiries');
    }
}

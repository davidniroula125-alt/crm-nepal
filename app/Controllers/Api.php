<?php namespace App\Controllers;

use App\Models\SupportMessage;

class Api extends BaseController
{
    public function chatbotSubmit()
    {
        $data = $this->request->getJSON(true);
        
        $supportModel = new SupportMessage();
        
        $supportModel->insert([
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'subject' => $data['subject'] ?? 'Chatbot Demo Request',
            'message' => json_encode($data),
            'type' => 'chatbot',
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        return $this->response->setJSON(['success' => true, 'message' => 'Thank you! We will contact you soon.']);
    }

    public function getDeals()
    {
        $companyId = $this->session->get('user')['company_id'] ?? null;
        if (!$companyId) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }
        
        $dealModel = new \App\Models\Deal();
        $deals = $dealModel->where('company_id', $companyId)->findAll();
        
        return $this->response->setJSON($deals);
    }
}

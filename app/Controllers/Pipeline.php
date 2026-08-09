<?php namespace App\Controllers;

use App\Models\Deal;
use App\Models\Contact;

class Pipeline extends BaseController
{
    public function index()
    {
        $companyId = $this->session->get('user')['company_id'];
        $dealModel = new Deal();
        $contactModel = new Contact();
        
        $deals = $dealModel->where('company_id', $companyId)->findAll();
        $contacts = $contactModel->where('company_id', $companyId)->findAll();
        
        $stages = ['lead' => [], 'proposals' => [], 'negotiation' => [], 'closed_won' => [], 'closed_lost' => []];
        foreach ($deals as $deal) {
            $stages[$deal['stage']][] = $deal;
        }
        
        return view('pages/pipeline', [
            'stages' => $stages,
            'contacts' => $contacts,
        ]);
    }

    public function store()
    {
        $companyId = $this->session->get('user')['company_id'];
        $dealModel = new Deal();
        
        $dealModel->insert([
            'company_id' => $companyId,
            'contact_id' => $this->request->getPost('contact_id') ?: null,
            'title' => $this->request->getPost('title'),
            'stage' => $this->request->getPost('stage') ?: 'lead',
            'value' => $this->request->getPost('value') ?: 0,
            'assigned_to' => $this->session->get('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('deal_created', 'deal', $dealModel->insertID());
        
        return redirect()->to('/pipeline');
    }

    public function update($id)
    {
        $dealModel = new Deal();
        $dealModel->update($id, [
            'title' => $this->request->getPost('title'),
            'contact_id' => $this->request->getPost('contact_id') ?: null,
            'stage' => $this->request->getPost('stage'),
            'value' => $this->request->getPost('value'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('deal_updated', 'deal', $id);
        
        return redirect()->to('/pipeline');
    }

    public function updateStage()
    {
        $dealId = $this->request->getPost('deal_id');
        $stage = $this->request->getPost('stage');
        
        $dealModel = new Deal();
        $dealModel->update($dealId, [
            'stage' => $stage,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('deal_stage_changed', 'deal', $dealId);
        
        return $this->response->setJSON(['success' => true]);
    }

    public function delete($id)
    {
        $dealModel = new Deal();
        $dealModel->delete($id);
        log_activity('deal_deleted', 'deal', $id);
        return redirect()->to('/pipeline');
    }
}

<?php namespace App\Controllers;

use App\Models\Contact;

class Contacts extends BaseController
{
    public function index()
    {
        $companyId = $this->session->get('user')['company_id'];
        $contactModel = new Contact();
        
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $query = $contactModel->where('company_id', $companyId);
        
        if ($search) {
            $query->groupStart()
                ->like('name', $search)
                ->orLike('email', $search)
                ->orLike('phone', $search)
                ->orLike('company_name', $search)
                ->groupEnd();
        }
        if ($status) {
            $query->where('status', $status);
        }
        
        $page = (int)($this->request->getGet('page') ?: 1);
        $perPage = 10;
        $total = $query->countAllResults(false);
        $contacts = $query->orderBy('created_at', 'DESC')->limit($perPage, ($page - 1) * $perPage)->findAll();
        
        $data = [
            'contacts' => $contacts,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage),
            'search' => $search,
            'status' => $status,
        ];
        
        return view('pages/contacts', $data);
    }

    public function create()
    {
        return view('pages/contacts_form', ['contact' => null]);
    }

    public function store()
    {
        $contactModel = new Contact();
        $companyId = $this->session->get('user')['company_id'];
        
        $contactModel->insert([
            'company_id' => $companyId,
            'name' => $this->request->getPost('name'),
            'company_name' => $this->request->getPost('company_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'status' => $this->request->getPost('status') ?: 'lead',
            'value' => $this->request->getPost('value') ?: 0,
            'last_contact_date' => $this->request->getPost('last_contact_date') ?: date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('contact_created', 'contact', $contactModel->insertID());
        
        return redirect()->to('/contacts');
    }

    public function edit($id)
    {
        $contactModel = new Contact();
        $contact = $contactModel->find($id);
        if (!$contact) {
            return redirect()->to('/contacts');
        }
        return view('pages/contacts_form', ['contact' => $contact]);
    }

    public function update($id)
    {
        $contactModel = new Contact();
        $contactModel->update($id, [
            'name' => $this->request->getPost('name'),
            'company_name' => $this->request->getPost('company_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'status' => $this->request->getPost('status'),
            'value' => $this->request->getPost('value'),
            'last_contact_date' => $this->request->getPost('last_contact_date'),
        ]);
        
        log_activity('contact_updated', 'contact', $id);
        
        return redirect()->to('/contacts');
    }

    public function delete($id)
    {
        $contactModel = new Contact();
        $contactModel->delete($id);
        log_activity('contact_deleted', 'contact', $id);
        return redirect()->to('/contacts');
    }

    public function view($id)
    {
        $contactModel = new Contact();
        $contact = $contactModel->find($id);
        if (!$contact) {
            return redirect()->to('/contacts');
        }
        return view('pages/contact_detail', ['contact' => $contact]);
    }
}
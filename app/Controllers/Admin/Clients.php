<?php

namespace App\Controllers\Admin;

use App\Models\ClientModel;
use App\Models\LeadModel;
use App\Models\SubscriptionModel;
use App\Models\PaymentModel;

class Clients extends BaseController
{
    protected $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';
        $page   = max((int) ($this->request->getGet('page') ?? 1), 1);
        $perPage = 20;

        $query = $this->clientModel->searchByName($search)->filterByStatus($status);
        $total = $this->clientModel->countAllFiltered($search, $status);
        $clients = $query->orderBy('id', 'DESC')->paginate($perPage, 'default', $page);

        $data = [
            'pageTitle'   => 'Clients',
            'clients'     => $clients,
            'search'      => $search,
            'status'      => $status,
            'pager'       => $this->clientModel->pager,
            'total'       => $total,
        ];

        return view('admin/clients/index', $data);
    }

    public function create()
    {
        $leadModel = new LeadModel();

        $data = [
            'pageTitle' => 'Add New Client',
            'leads'     => $leadModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('admin/clients/create', $data);
    }

    public function store()
    {
        $rules = [
            'company_name' => 'required|max_length[255]',
            'contact_name' => 'required|max_length[255]',
            'email'        => 'required|valid_email|max_length[255]',
            'phone'        => 'permit_empty|max_length[50]',
            'address'      => 'permit_empty',
            'lead_id'      => 'permit_empty',
            'status'       => 'required|in_list[active,inactive]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $leadId = $this->request->getPost('lead_id');
        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'contact_name' => $this->request->getPost('contact_name'),
            'email'        => $this->request->getPost('email'),
            'phone'        => $this->request->getPost('phone'),
            'address'      => $this->request->getPost('address'),
            'lead_id'      => $leadId !== '' ? (int) $leadId : null,
            'status'       => $this->request->getPost('status'),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        if (! $this->clientModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', $this->clientModel->errors()
                ? implode('<br>', $this->clientModel->errors())
                : 'Failed to create client.');
        }

        return redirect()->to('/admin/clients')->with('success', 'Client created successfully.');
    }

    public function show($id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/admin/clients')->with('error', 'Client not found.');
        }

        $subscriptionModel = new SubscriptionModel();
        $paymentModel      = new PaymentModel();

        $data = [
            'pageTitle'     => 'Client Details',
            'client'        => $client,
            'subscriptions' => $subscriptionModel->where('client_id', $id)->orderBy('id', 'DESC')->findAll(),
            'payments'      => $paymentModel->where('client_id', $id)->orderBy('id', 'DESC')->findAll(),
        ];

        return view('admin/clients/show', $data);
    }

    public function edit($id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/admin/clients')->with('error', 'Client not found.');
        }

        $leadModel = new LeadModel();

        $data = [
            'pageTitle' => 'Edit Client',
            'client'    => $client,
            'leads'     => $leadModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('admin/clients/edit', $data);
    }

    public function update($id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/admin/clients')->with('error', 'Client not found.');
        }

        $rules = [
            'company_name' => 'required|max_length[255]',
            'contact_name' => 'required|max_length[255]',
            'email'        => "required|valid_email|max_length[255]|is_unique[clients.email,id,{$id}]",
            'phone'        => 'permit_empty|max_length[50]',
            'address'      => 'permit_empty',
            'lead_id'      => 'permit_empty',
            'status'       => 'required|in_list[active,inactive]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $leadId = $this->request->getPost('lead_id');
        $data = [
            'company_name' => $this->request->getPost('company_name'),
            'contact_name' => $this->request->getPost('contact_name'),
            'email'        => $this->request->getPost('email'),
            'phone'        => $this->request->getPost('phone'),
            'address'      => $this->request->getPost('address'),
            'lead_id'      => $leadId !== '' ? (int) $leadId : null,
            'status'       => $this->request->getPost('status'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        if (! $this->clientModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', $this->clientModel->errors()
                ? implode('<br>', $this->clientModel->errors())
                : 'Failed to update client.');
        }

        return redirect()->to("/admin/clients/{$id}")->with('success', 'Client updated successfully.');
    }

    public function delete($id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/admin/clients')->with('error', 'Client not found.');
        }

        $this->clientModel->delete($id);

        return redirect()->to('/admin/clients')->with('success', 'Client deleted successfully.');
    }
}

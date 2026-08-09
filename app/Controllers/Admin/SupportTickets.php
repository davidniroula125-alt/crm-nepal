<?php

namespace App\Controllers\Admin;

use App\Models\SupportTicketModel;
use App\Models\ClientModel;
use App\Models\UserModel;

class SupportTickets extends BaseController
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new SupportTicketModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status') ?? '';
        $page   = max((int) ($this->request->getGet('page') ?? 1), 1);
        $perPage = 20;

        $total = $this->ticketModel->countAllFiltered($status);
        $tickets = $this->ticketModel
            ->filterByStatus($status)
            ->orderBy('id', 'DESC')
            ->paginate($perPage, 'default', $page);

        $clientModel = new ClientModel();
        $userModel   = new UserModel();
        $clients     = $clientModel->orderBy('id', 'ASC')->findAll();
        $users       = $userModel->orderBy('id', 'ASC')->findAll();

        $clientMap = [];
        foreach ($clients as $c) {
            $clientMap[$c->id] = $c->company_name;
        }

        $userMap = [];
        foreach ($users as $u) {
            $userMap[$u->id] = $u->name;
        }

        $data = [
            'pageTitle'  => 'Support Tickets',
            'tickets'    => $tickets,
            'status'     => $status,
            'pager'      => $this->ticketModel->pager,
            'total'      => $total,
            'clientMap'  => $clientMap,
            'userMap'    => $userMap,
        ];

        return view('admin/support_tickets/index', $data);
    }

    public function create()
    {
        $clientModel = new ClientModel();
        $userModel   = new UserModel();

        $data = [
            'pageTitle' => 'Create Support Ticket',
            'clients'   => $clientModel->orderBy('id', 'ASC')->findAll(),
            'users'     => $userModel->where('is_active', 1)->orderBy('id', 'ASC')->findAll(),
        ];

        return view('admin/support_tickets/create', $data);
    }

    public function store()
    {
        $rules = [
            'client_id'   => 'permit_empty|is_not_unique[support_tickets.client_id]',
            'subject'     => 'required|max_length[150]',
            'description' => 'required',
            'assigned_to' => 'permit_empty|is_not_unique[support_tickets.assigned_to]',
            'status'      => 'required|in_list[Open,In Progress,Resolved,Closed]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $clientId  = $this->request->getPost('client_id');
        $assignedTo = $this->request->getPost('assigned_to');

        $data = [
            'client_id'   => $clientId !== '' ? (int) $clientId : null,
            'subject'     => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
            'assigned_to' => $assignedTo !== '' ? (int) $assignedTo : null,
            'status'      => $this->request->getPost('status'),
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        if (! $this->ticketModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', $this->ticketModel->errors()
                ? implode('<br>', $this->ticketModel->errors())
                : 'Failed to create support ticket.');
        }

        return redirect()->to('/admin/support-tickets')->with('success', 'Support ticket created successfully.');
    }

    public function show($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (! $ticket) {
            return redirect()->to('/admin/support-tickets')->with('error', 'Support ticket not found.');
        }

        $clientModel = new ClientModel();
        $userModel   = new UserModel();

        $client = $ticket->client_id ? $clientModel->find($ticket->client_id) : null;
        $assignee = $ticket->assigned_to ? $userModel->find($ticket->assigned_to) : null;

        $data = [
            'pageTitle' => 'Support Ticket Details',
            'ticket'    => $ticket,
            'client'    => $client,
            'assignee'  => $assignee,
        ];

        return view('admin/support_tickets/show', $data);
    }

    public function edit($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (! $ticket) {
            return redirect()->to('/admin/support-tickets')->with('error', 'Support ticket not found.');
        }

        $clientModel = new ClientModel();
        $userModel   = new UserModel();

        $data = [
            'pageTitle' => 'Edit Support Ticket',
            'ticket'    => $ticket,
            'clients'   => $clientModel->orderBy('id', 'ASC')->findAll(),
            'users'     => $userModel->where('is_active', 1)->orderBy('id', 'ASC')->findAll(),
        ];

        return view('admin/support_tickets/edit', $data);
    }

    public function update($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (! $ticket) {
            return redirect()->to('/admin/support-tickets')->with('error', 'Support ticket not found.');
        }

        $rules = [
            'client_id'   => 'permit_empty',
            'subject'     => 'required|max_length[150]',
            'description' => 'required',
            'assigned_to' => 'permit_empty',
            'status'      => 'required|in_list[Open,In Progress,Resolved,Closed]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $clientId  = $this->request->getPost('client_id');
        $assignedTo = $this->request->getPost('assigned_to');

        $data = [
            'client_id'   => $clientId !== '' ? (int) $clientId : null,
            'subject'     => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
            'assigned_to' => $assignedTo !== '' ? (int) $assignedTo : null,
            'status'      => $this->request->getPost('status'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        if (! $this->ticketModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', $this->ticketModel->errors()
                ? implode('<br>', $this->ticketModel->errors())
                : 'Failed to update support ticket.');
        }

        return redirect()->to("/admin/support-tickets/{$id}")->with('success', 'Support ticket updated successfully.');
    }

    public function delete($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (! $ticket) {
            return redirect()->to('/admin/support-tickets')->with('error', 'Support ticket not found.');
        }

        $this->ticketModel->delete($id);

        return redirect()->to('/admin/support-tickets')->with('success', 'Support ticket deleted successfully.');
    }
}

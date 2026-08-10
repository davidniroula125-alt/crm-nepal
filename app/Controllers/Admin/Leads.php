<?php

namespace App\Controllers\Admin;

use App\Models\LeadModel;
use App\Models\ClientModel;
use App\Models\UserModel;
use App\Models\ActivityLogModel;
use CodeIgniter\HTTP\ResponseInterface;

class Leads extends BaseController
{
    protected $leadModel;
    protected $userModel;
    protected $activityLog;

    public function __construct()
    {
        $this->leadModel    = new LeadModel();
        $this->userModel    = new UserModel();
        $this->activityLog  = new ActivityLogModel();
    }

    /**
     * List all leads with search/filter. Paginate with 20 per page.
     */
    public function index()
    {
        $filters = [
            'search'      => $this->request->getVar('search') ?? '',
            'status'      => $this->request->getVar('status') ?? '',
            'source'      => $this->request->getVar('source') ?? '',
            'assigned_to' => $this->request->getVar('assigned_to') ?? '',
            'page'        => $this->request->getVar('page') ?? 1,
        ];

        $data = $this->leadModel->getLeadsFiltered($filters, 20);

        $users = $this->userModel->orderBy('name', 'ASC')->findAll();

        $statusOptions = ['New', 'Contacted', 'Qualified', 'Converted', 'Lost'];
        $sourceOptions = [
            'Website', 'Facebook', 'Google', 'Referral', 'Phone', 'Email',
            'Exhibition/Event', 'Existing Customer', 'Other', 'Demo Request',
        ];

        return view('admin/leads/index', [
            'pageTitle'     => 'Leads',
            'leads'         => $data['leads'],
            'total'         => $data['total'],
            'perPage'       => $data['perPage'],
            'currentPage'   => $data['currentPage'],
            'users'         => $users,
            'filters'       => $filters,
            'statusOptions' => $statusOptions,
            'sourceOptions' => $sourceOptions,
        ]);
    }

    /**
     * Show create form. Get all users for assignment dropdown.
     */
    public function create()
    {
        $users = $this->userModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

        $sourceOptions = [
            'Website', 'Facebook', 'Google', 'Referral', 'Phone', 'Email',
            'Exhibition/Event', 'Existing Customer', 'Other', 'Demo Request',
        ];

        $statusOptions = ['New', 'Contacted', 'Qualified', 'Converted', 'Lost'];

        return view('admin/leads/create', [
            'pageTitle'     => 'Create Lead',
            'users'         => $users,
            'sourceOptions' => $sourceOptions,
            'statusOptions' => $statusOptions,
        ]);
    }

    /**
     * Validate and save new lead. Redirect to leads list.
     */
    public function store()
    {
        $rules = [
            'full_name'         => 'required|max_length[150]',
            'email'             => 'permit_empty|valid_email',
            'source'            => 'required',
            'status'            => 'permit_empty',
            'company_name'      => 'permit_empty|max_length[150]',
            'phone'             => 'permit_empty|max_length[30]',
            'assigned_to'       => 'permit_empty|integer',
            'notes'             => 'permit_empty',
            'next_follow_up_at' => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $leadData = [
            'full_name'         => $this->request->getPost('full_name'),
            'company_name'      => $this->request->getPost('company_name'),
            'email'             => $this->request->getPost('email'),
            'phone'             => $this->request->getPost('phone'),
            'source'            => $this->request->getPost('source'),
            'status'            => $this->request->getPost('status') ?: 'New',
            'assigned_to'       => $this->request->getPost('assigned_to') ?: null,
            'notes'             => $this->request->getPost('notes'),
            'next_follow_up_at' => $this->request->getPost('next_follow_up_at')
                ? date('Y-m-d H:i:s', strtotime($this->request->getPost('next_follow_up_at')))
                : null,
            'created_at'        => date('Y-m-d H:i:s'),
        ];

        $leadId = $this->leadModel->insert($leadData);

        if ($leadId) {
            $this->activityLog->log(
                session()->get('user_id'),
                'Created lead',
                'leads',
                $leadId
            );

            return redirect()->to('/admin/leads')
                ->with('success', 'Lead created successfully.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create lead. Please try again.');
    }

    /**
     * Show single lead with all details.
     */
    public function show($id = null)
    {
        $lead = $this->leadModel->findWithUser((int) $id);

        if (! $lead) {
            return redirect()->to('/admin/leads')
                ->with('error', 'Lead not found.');
        }

        // Get follow-ups for this lead
        $followUps = $this->leadModel->db->table('follow_ups')
            ->where('lead_id', $id)
            ->orderBy('due_at', 'DESC')
            ->get()
            ->getResult();

        return view('admin/leads/show', [
            'pageTitle' => 'Lead Details',
            'lead'      => $lead,
            'followUps' => $followUps,
        ]);
    }

    /**
     * Show edit form pre-filled with lead data.
     */
    public function edit($id = null)
    {
        $lead = $this->leadModel->find((int) $id);

        if (! $lead) {
            return redirect()->to('/admin/leads')
                ->with('error', 'Lead not found.');
        }

        $users = $this->userModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll();

        $sourceOptions = [
            'Website', 'Facebook', 'Google', 'Referral', 'Phone', 'Email',
            'Exhibition/Event', 'Existing Customer', 'Other', 'Demo Request',
        ];

        $statusOptions = ['New', 'Contacted', 'Qualified', 'Converted', 'Lost'];

        return view('admin/leads/edit', [
            'pageTitle'     => 'Edit Lead',
            'lead'          => $lead,
            'users'         => $users,
            'sourceOptions' => $sourceOptions,
            'statusOptions' => $statusOptions,
        ]);
    }

    /**
     * Validate and update lead. Redirect back with success.
     */
    public function update($id = null)
    {
        $lead = $this->leadModel->find((int) $id);

        if (! $lead) {
            return redirect()->to('/admin/leads')
                ->with('error', 'Lead not found.');
        }

        $rules = [
            'full_name'         => 'required|max_length[150]',
            'email'             => 'permit_empty|valid_email',
            'source'            => 'required',
            'status'            => 'permit_empty',
            'company_name'      => 'permit_empty|max_length[150]',
            'phone'             => 'permit_empty|max_length[30]',
            'assigned_to'       => 'permit_empty|integer',
            'notes'             => 'permit_empty',
            'next_follow_up_at' => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $leadData = [
            'full_name'         => $this->request->getPost('full_name'),
            'company_name'      => $this->request->getPost('company_name'),
            'email'             => $this->request->getPost('email'),
            'phone'             => $this->request->getPost('phone'),
            'source'            => $this->request->getPost('source'),
            'status'            => $this->request->getPost('status') ?: 'New',
            'assigned_to'       => $this->request->getPost('assigned_to') ?: null,
            'notes'             => $this->request->getPost('notes'),
            'next_follow_up_at' => $this->request->getPost('next_follow_up_at')
                ? date('Y-m-d H:i:s', strtotime($this->request->getPost('next_follow_up_at')))
                : null,
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        $updated = $this->leadModel->update((int) $id, $leadData);

        if ($updated) {
            $this->activityLog->log(
                session()->get('user_id'),
                'Updated lead',
                'leads',
                (int) $id
            );

            // Auto-create client when lead is converted via edit form
            if (($leadData['status'] ?? '') === 'Converted' && $lead->status !== 'Converted') {
                $this->convertLeadToClient((object) array_merge((array) $lead, $leadData));
            }

            return redirect()->to('/admin/leads/' . $id)
                ->with('success', 'Lead updated successfully.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update lead. Please try again.');
    }

    /**
     * Delete lead and redirect back.
     */
    public function delete($id = null)
    {
        $lead = $this->leadModel->find((int) $id);

        if (! $lead) {
            return redirect()->to('/admin/leads')
                ->with('error', 'Lead not found.');
        }

        $deleted = $this->leadModel->delete((int) $id);

        if ($deleted) {
            $this->activityLog->log(
                session()->get('user_id'),
                'Deleted lead',
                'leads',
                (int) $id
            );

            return redirect()->to('/admin/leads')
                ->with('success', 'Lead deleted successfully.');
        }

        return redirect()->back()
            ->with('error', 'Failed to delete lead. Please try again.');
    }

    /**
     * AJAX endpoint to change lead status. Matches route: leads/(:num)/status
     */
    public function updateStatus($id = null): ResponseInterface
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Invalid request.',
            ]);
        }

        $lead = $this->leadModel->find((int) $id);

        if (! $lead) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Lead not found.',
            ]);
        }

        $status = $this->request->getPost('status');

        $allowedStatuses = ['New', 'Contacted', 'Qualified', 'Converted', 'Lost'];

        if (! in_array($status, $allowedStatuses)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'message' => 'Invalid status value.',
            ]);
        }

        $updated = $this->leadModel->update((int) $id, [
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($updated) {
            $this->activityLog->log(
                session()->get('user_id'),
                'Changed lead status to ' . $status,
                'leads',
                (int) $id
            );

            // Auto-create client when lead is converted
            if ($status === 'Converted') {
                $this->convertLeadToClient($lead);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated to ' . $status . '.',
                'status'  => $status,
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Failed to update status.',
        ]);
    }

    /**
     * Export leads as CSV.
     */
    public function export()
    {
        $filters = [
            'search'      => $this->request->getVar('search') ?? '',
            'status'      => $this->request->getVar('status') ?? '',
            'source'      => $this->request->getVar('source') ?? '',
            'assigned_to' => $this->request->getVar('assigned_to') ?? '',
        ];

        $builder = $this->leadModel->select('leads.*, users.name as assigned_to_name')
            ->join('users', 'users.id = leads.assigned_to', 'left');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                ->like('leads.full_name', $search)
                ->orLike('leads.email', $search)
                ->orLike('leads.company_name', $search)
                ->groupEnd();
        }

        if (! empty($filters['status'])) {
            $builder->where('leads.status', $filters['status']);
        }

        if (! empty($filters['source'])) {
            $builder->where('leads.source', $filters['source']);
        }

        if (! empty($filters['assigned_to'])) {
            $builder->where('leads.assigned_to', $filters['assigned_to']);
        }

        $leads = $builder->orderBy('leads.id', 'DESC')->get()->getResult();

        $filename = 'leads_export_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // UTF-8 BOM for Excel compatibility
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header row
        fputcsv($output, [
            'ID', 'Full Name', 'Company', 'Email', 'Phone',
            'Source', 'Status', 'Assigned To', 'Notes',
            'Next Follow-up', 'Created At',
        ]);

        foreach ($leads as $lead) {
            fputcsv($output, [
                $lead->id,
                $lead->full_name,
                $lead->company_name,
                $lead->email,
                $lead->phone,
                $lead->source,
                $lead->status,
                $lead->assigned_to_name ?? '',
                $lead->notes,
                $lead->next_follow_up_at,
                $lead->created_at,
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Create a client from a converted lead.
     * Skips if a client with the same lead_id already exists.
     */
    protected function convertLeadToClient(object $lead): void
    {
        try {
            $clientModel = new ClientModel();

            // Don't create duplicate client if one already linked to this lead
            $existing = $clientModel->where('lead_id', $lead->id)->first();
            if ($existing) {
                return;
            }

            $clientData = [
                'lead_id'      => $lead->id,
                'company_name' => $lead->company_name ?: $lead->full_name,
                'contact_name' => $lead->full_name,
                'email'        => $lead->email ?? '',
                'phone'        => $lead->phone ?? '',
                'status'       => 'Active',
                'created_at'   => date('Y-m-d H:i:s'),
            ];

            $clientId = $clientModel->insert($clientData);

            if ($clientId) {
                $this->activityLog->log(
                    session()->get('user_id'),
                    'Auto-created client from lead',
                    'clients',
                    $clientId
                );
            }
        } catch (\Throwable $e) {
            // Silently fail — don't block the lead status update
        }
    }
}

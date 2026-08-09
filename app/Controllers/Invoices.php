<?php namespace App\Controllers;

use App\Models\Invoice;
use App\Models\Contact;

class Invoices extends BaseController
{
    public function index()
    {
        $companyId = $this->session->get('user')['company_id'];
        $invoiceModel = new Invoice();
        $contactModel = new Contact();
        
        $invoices = $invoiceModel->where('company_id', $companyId)->orderBy('created_at', 'DESC')->findAll();
        $contacts = $contactModel->where('company_id', $companyId)->findAll();
        
        $totalPaid = $invoiceModel->where('company_id', $companyId)->where('status', 'paid')->selectSum('amount')->first();
        $totalPending = $invoiceModel->where('company_id', $companyId)->where('status', 'pending')->selectSum('amount')->first();
        $totalOverdue = $invoiceModel->where('company_id', $companyId)->where('status', 'overdue')->selectSum('amount')->first();
        
        return view('pages/invoices', [
            'invoices' => $invoices,
            'contacts' => $contacts,
            'totalPaid' => (float)($totalPaid['amount'] ?? 0),
            'totalPending' => (float)($totalPending['amount'] ?? 0),
            'totalOverdue' => (float)($totalOverdue['amount'] ?? 0),
        ]);
    }

    public function create()
    {
        $companyId = $this->session->get('user')['company_id'];
        $contactModel = new Contact();
        $invoiceModel = new Invoice();
        
        return view('pages/invoices_form', [
            'invoice' => null,
            'contacts' => $contactModel->where('company_id', $companyId)->findAll(),
            'invoiceNumber' => $invoiceModel->generateNumber($companyId),
        ]);
    }

    public function store()
    {
        $companyId = $this->session->get('user')['company_id'];
        $invoiceModel = new Invoice();
        
        $amount = (float)$this->request->getPost('amount');
        $vatAmount = $amount * 0.13;
        
        $invoiceModel->insert([
            'company_id' => $companyId,
            'contact_id' => $this->request->getPost('contact_id') ?: null,
            'invoice_number' => $this->request->getPost('invoice_number'),
            'amount' => $amount,
            'vat_amount' => $vatAmount,
            'payment_method' => $this->request->getPost('payment_method') ?: 'bank_transfer',
            'status' => $this->request->getPost('status') ?: 'pending',
            'due_date' => $this->request->getPost('due_date'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('invoice_created', 'invoice', $invoiceModel->insertID());
        
        return redirect()->to('/invoices');
    }

    public function edit($id)
    {
        $companyId = $this->session->get('user')['company_id'];
        $invoiceModel = new Invoice();
        $contactModel = new Contact();
        $invoice = $invoiceModel->find($id);
        
        if (!$invoice) {
            return redirect()->to('/invoices');
        }
        
        return view('pages/invoices_form', [
            'invoice' => $invoice,
            'contacts' => $contactModel->where('company_id', $companyId)->findAll(),
            'invoiceNumber' => $invoice['invoice_number'],
        ]);
    }

    public function update($id)
    {
        $invoiceModel = new Invoice();
        $amount = (float)$this->request->getPost('amount');
        
        $invoiceModel->update($id, [
            'contact_id' => $this->request->getPost('contact_id') ?: null,
            'invoice_number' => $this->request->getPost('invoice_number'),
            'amount' => $amount,
            'vat_amount' => $amount * 0.13,
            'payment_method' => $this->request->getPost('payment_method'),
            'status' => $this->request->getPost('status'),
            'due_date' => $this->request->getPost('due_date'),
        ]);
        
        log_activity('invoice_updated', 'invoice', $id);
        
        return redirect()->to('/invoices');
    }

    public function delete($id)
    {
        $invoiceModel = new Invoice();
        $invoiceModel->delete($id);
        log_activity('invoice_deleted', 'invoice', $id);
        return redirect()->to('/invoices');
    }
}

<?php

namespace App\Controllers\Admin;

use App\Models\PaymentModel;
use App\Models\InvoiceModel;
use App\Models\ClientModel;
use App\Models\SubscriptionModel;

class Payments extends BaseController
{
    protected $paymentModel;
    protected $invoiceModel;
    protected $clientModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->invoiceModel = new InvoiceModel();
        $this->clientModel  = new ClientModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';
        $perPage = 20;

        $payments = $this->paymentModel
            ->select('payments.*, clients.company_name')
            ->join('clients', 'clients.id = payments.client_id', 'left')
            ->searchByClient($search)
            ->filterByStatus($status)
            ->orderBy('payments.id', 'DESC')
            ->paginate($perPage, 'default', $this->request->getGet('page'));

        $paymentIds = array_column($payments, 'id');
        $invoices = ! empty($paymentIds)
            ? $this->invoiceModel->whereIn('payment_id', $paymentIds)->findAll()
            : [];
        $invoiceMap = [];
        foreach ($invoices as $inv) {
            $invoiceMap[$inv->payment_id] = $inv;
        }

        $data = [
            'pageTitle'  => 'Payments',
            'payments'   => $payments,
            'invoiceMap' => $invoiceMap,
            'search'     => $search,
            'status'     => $status,
            'pager'      => $this->paymentModel->pager,
            'total'      => $this->paymentModel->countAllFiltered($search, $status),
        ];

        return view('admin/payments/index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'Record Payment',
            'clients'   => $this->clientModel->where('status', 'active')->orderBy('company_name', 'ASC')->findAll(),
        ];

        return view('admin/payments/create', $data);
    }

    public function store()
    {
        $rules = [
            'client_id'        => 'required|integer',
            'subscription_id'  => 'permit_empty|integer',
            'amount'           => 'required|decimal|greater_than[0]',
            'status'           => 'required|in_list[Paid,Pending,Overdue,Partial]',
            'due_date'         => 'permit_empty',
            'method'           => 'required',
            'notes'            => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $subscriptionId = $this->request->getPost('subscription_id');
        $paidAt = $this->request->getPost('status') === 'Paid' ? date('Y-m-d H:i:s') : null;

        $paymentData = [
            'client_id'       => (int) $this->request->getPost('client_id'),
            'subscription_id' => $subscriptionId !== '' ? (int) $subscriptionId : null,
            'amount'          => $this->request->getPost('amount'),
            'status'          => $this->request->getPost('status'),
            'paid_at'         => $paidAt,
            'due_date'        => $this->request->getPost('due_date') ?: null,
            'method'          => $this->request->getPost('method'),
            'notes'           => $this->request->getPost('notes'),
            'created_at'      => date('Y-m-d H:i:s'),
        ];

        $paymentId = $this->paymentModel->insert($paymentData);

        if (! $paymentId) {
            return redirect()->back()->withInput()->with('error',
                $this->paymentModel->errors()
                    ? implode('<br>', $this->paymentModel->errors())
                    : 'Failed to create payment.'
            );
        }

        $invoiceData = [
            'payment_id'      => $paymentId,
            'invoice_number'  => $this->paymentModel->getNextInvoiceNumber(),
            'issued_at'       => date('Y-m-d H:i:s'),
        ];

        if (! $this->invoiceModel->insert($invoiceData)) {
            return redirect()->back()->withInput()->with('error',
                $this->invoiceModel->errors()
                    ? implode('<br>', $this->invoiceModel->errors())
                    : 'Payment saved but failed to create invoice.'
            );
        }

        return redirect()->to('/admin/payments')->with('success', 'Payment recorded successfully.');
    }

    public function show($id)
    {
        $payment = $this->paymentModel
            ->select('payments.*, clients.company_name, clients.contact_name, clients.email')
            ->join('clients', 'clients.id = payments.client_id', 'left')
            ->where('payments.id', $id)
            ->first();

        if (! $payment) {
            return redirect()->to('/admin/payments')->with('error', 'Payment not found.');
        }

        $invoice = $this->invoiceModel->where('payment_id', $id)->first();

        $data = [
            'pageTitle' => 'Payment Details',
            'payment'   => $payment,
            'invoice'   => $invoice,
        ];

        return view('admin/payments/show', $data);
    }

    public function edit($id)
    {
        $payment = $this->paymentModel->find($id);

        if (! $payment) {
            return redirect()->to('/admin/payments')->with('error', 'Payment not found.');
        }

        $data = [
            'pageTitle' => 'Edit Payment',
            'payment'   => $payment,
            'clients'   => $this->clientModel->where('status', 'active')->orderBy('company_name', 'ASC')->findAll(),
        ];

        return view('admin/payments/edit', $data);
    }

    public function update($id)
    {
        $payment = $this->paymentModel->find($id);

        if (! $payment) {
            return redirect()->to('/admin/payments')->with('error', 'Payment not found.');
        }

        $rules = [
            'client_id'        => 'required|integer',
            'subscription_id'  => 'permit_empty|integer',
            'amount'           => 'required|decimal|greater_than[0]',
            'status'           => 'required|in_list[Paid,Pending,Overdue,Partial]',
            'due_date'         => 'permit_empty',
            'method'           => 'required',
            'notes'            => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $subscriptionId = $this->request->getPost('subscription_id');
        $status = $this->request->getPost('status');

        $paidAt = $payment->paid_at;
        if ($status === 'Paid' && $paidAt === null) {
            $paidAt = date('Y-m-d H:i:s');
        } elseif ($status !== 'Paid') {
            $paidAt = null;
        }

        $data = [
            'client_id'       => (int) $this->request->getPost('client_id'),
            'subscription_id' => $subscriptionId !== '' ? (int) $subscriptionId : null,
            'amount'          => $this->request->getPost('amount'),
            'status'          => $status,
            'paid_at'         => $paidAt,
            'due_date'        => $this->request->getPost('due_date') ?: null,
            'method'          => $this->request->getPost('method'),
            'notes'           => $this->request->getPost('notes'),
        ];

        if (! $this->paymentModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error',
                $this->paymentModel->errors()
                    ? implode('<br>', $this->paymentModel->errors())
                    : 'Failed to update payment.'
            );
        }

        return redirect()->to("/admin/payments/{$id}")->with('success', 'Payment updated successfully.');
    }

    public function delete($id)
    {
        $payment = $this->paymentModel->find($id);

        if (! $payment) {
            return redirect()->to('/admin/payments')->with('error', 'Payment not found.');
        }

        $this->invoiceModel->where('payment_id', $id)->delete();
        $this->paymentModel->delete($id);

        return redirect()->to('/admin/payments')->with('success', 'Payment deleted successfully.');
    }

    public function markPaid($id)
    {
        $payment = $this->paymentModel->find($id);

        if (! $payment) {
            return redirect()->to('/admin/payments')->with('error', 'Payment not found.');
        }

        $this->paymentModel->update($id, [
            'status'  => 'Paid',
            'paid_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Payment marked as Paid.');
    }
}

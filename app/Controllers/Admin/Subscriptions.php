<?php

namespace App\Controllers\Admin;

use App\Models\SubscriptionModel;
use App\Models\ClientModel;
use App\Models\PricingPlanModel;

class Subscriptions extends BaseController
{
    protected $subscriptionModel;
    protected $clientModel;
    protected $pricingPlanModel;

    public function __construct()
    {
        $this->subscriptionModel = new SubscriptionModel();
        $this->clientModel       = new ClientModel();
        $this->pricingPlanModel  = new PricingPlanModel();
    }

    public function index()
    {
        $search  = $this->request->getGet('search') ?? '';
        $status  = $this->request->getGet('status') ?? '';
        $page    = max((int) ($this->request->getGet('page') ?? 1), 1);
        $perPage = 20;

        $query  = $this->subscriptionModel->searchByClient($search)->filterByStatus($status);
        $total  = $this->subscriptionModel->countAllFiltered($search, $status);
        $subscriptions = $query->orderBy('subscriptions.id', 'DESC')->paginate($perPage, 'default', $page);

        foreach ($subscriptions as $sub) {
            $sub->client_name = $this->subscriptionModel->getClientName($sub->client_id);
        }

        $data = [
            'pageTitle'     => 'Subscriptions',
            'subscriptions' => $subscriptions,
            'search'        => $search,
            'status'        => $status,
            'pager'         => $this->subscriptionModel->pager,
            'total'         => $total,
        ];

        return view('admin/subscriptions/index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle'    => 'Add New Subscription',
            'clients'      => $this->clientModel->orderBy('contact_name', 'ASC')->findAll(),
            'pricingPlans' => $this->pricingPlanModel->getActivePlans(),
        ];

        return view('admin/subscriptions/create', $data);
    }

    public function store()
    {
        $rules = [
            'client_id'     => 'required|integer',
            'plan_name'     => 'required|max_length[255]',
            'billing_cycle' => 'required|in_list[monthly,annual]',
            'amount'        => 'required|decimal',
            'start_date'    => 'required',
            'end_date'      => 'permit_empty',
            'status'        => 'required|in_list[active,expiring,expired,cancelled]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $endDate = $this->request->getPost('end_date');

        $data = [
            'client_id'     => (int) $this->request->getPost('client_id'),
            'plan_name'     => $this->request->getPost('plan_name'),
            'billing_cycle' => $this->request->getPost('billing_cycle'),
            'amount'        => $this->request->getPost('amount'),
            'start_date'    => $this->request->getPost('start_date'),
            'end_date'      => $endDate !== '' ? $endDate : null,
            'status'        => $this->request->getPost('status'),
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        if (! $this->subscriptionModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', $this->subscriptionModel->errors()
                ? implode('<br>', $this->subscriptionModel->errors())
                : 'Failed to create subscription.');
        }

        return redirect()->to('/admin/subscriptions')->with('success', 'Subscription created successfully.');
    }

    public function show($id)
    {
        $subscription = $this->subscriptionModel->find($id);

        if (! $subscription) {
            return redirect()->to('/admin/subscriptions')->with('error', 'Subscription not found.');
        }

        $subscription->client_name = $this->subscriptionModel->getClientName($subscription->client_id);

        $data = [
            'pageTitle'    => 'Subscription Details',
            'subscription' => $subscription,
        ];

        return view('admin/subscriptions/show', $data);
    }

    public function edit($id)
    {
        $subscription = $this->subscriptionModel->find($id);

        if (! $subscription) {
            return redirect()->to('/admin/subscriptions')->with('error', 'Subscription not found.');
        }

        $data = [
            'pageTitle'    => 'Edit Subscription',
            'subscription' => $subscription,
            'clients'      => $this->clientModel->orderBy('contact_name', 'ASC')->findAll(),
            'pricingPlans' => $this->pricingPlanModel->getActivePlans(),
        ];

        return view('admin/subscriptions/edit', $data);
    }

    public function update($id)
    {
        $subscription = $this->subscriptionModel->find($id);

        if (! $subscription) {
            return redirect()->to('/admin/subscriptions')->with('error', 'Subscription not found.');
        }

        $rules = [
            'client_id'     => 'required|integer',
            'plan_name'     => 'required|max_length[255]',
            'billing_cycle' => 'required|in_list[monthly,annual]',
            'amount'        => 'required|decimal',
            'start_date'    => 'required',
            'end_date'      => 'permit_empty',
            'status'        => 'required|in_list[active,expiring,expired,cancelled]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $endDate = $this->request->getPost('end_date');

        $data = [
            'client_id'     => (int) $this->request->getPost('client_id'),
            'plan_name'     => $this->request->getPost('plan_name'),
            'billing_cycle' => $this->request->getPost('billing_cycle'),
            'amount'        => $this->request->getPost('amount'),
            'start_date'    => $this->request->getPost('start_date'),
            'end_date'      => $endDate !== '' ? $endDate : null,
            'status'        => $this->request->getPost('status'),
        ];

        if (! $this->subscriptionModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', $this->subscriptionModel->errors()
                ? implode('<br>', $this->subscriptionModel->errors())
                : 'Failed to update subscription.');
        }

        return redirect()->to("/admin/subscriptions/{$id}")->with('success', 'Subscription updated successfully.');
    }

    public function delete($id)
    {
        $subscription = $this->subscriptionModel->find($id);

        if (! $subscription) {
            return redirect()->to('/admin/subscriptions')->with('error', 'Subscription not found.');
        }

        $this->subscriptionModel->delete($id);

        return redirect()->to('/admin/subscriptions')->with('success', 'Subscription deleted successfully.');
    }
}

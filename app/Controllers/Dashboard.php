<?php namespace App\Controllers;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Invoice;
use App\Models\ActivityLog;

class Dashboard extends BaseController
{
    public function index()
    {
        $companyId = $this->session->get('user')['company_id'];
        
        $contactModel = new Contact();
        $dealModel = new Deal();
        $invoiceModel = new Invoice();
        $activityModel = new ActivityLog();
        
        $pipelineValue = $dealModel->where('company_id', $companyId)->where('stage !=', 'closed_lost')->selectSum('value')->first();
        $pipelineValue = (float)($pipelineValue['value'] ?? 0);
        
        $activeLeads = $dealModel->where('company_id', $companyId)->where('stage', 'lead')->countAllResults();
        
        $totalDeals = $dealModel->where('company_id', $companyId)->countAllResults();
        $wonDeals = $dealModel->where('company_id', $companyId)->where('stage', 'closed_won')->countAllResults();
        $renewalRate = $totalDeals > 0 ? round(($wonDeals / $totalDeals) * 100, 1) : 0;
        
        $monthlyRevenue = $invoiceModel->where('company_id', $companyId)
            ->where('status', 'paid')
            ->selectSum('amount')->first();
        $monthlyRevenue = (float)($monthlyRevenue['amount'] ?? 0);
        
        $deals = $dealModel->where('company_id', $companyId)->findAll();
        $stages = ['lead' => [], 'proposals' => [], 'negotiation' => [], 'closed_won' => [], 'closed_lost' => []];
        foreach ($deals as $deal) {
            $stages[$deal['stage']][] = $deal;
        }
        
        $recentActivity = $activityModel->getByCompany($companyId, 10);
        
        return view('pages/dashboard', [
            'pipelineValue' => $pipelineValue,
            'activeLeads' => $activeLeads,
            'renewalRate' => $renewalRate,
            'monthlyRevenue' => $monthlyRevenue,
            'stages' => $stages,
            'recentActivity' => $recentActivity,
        ]);
    }
}
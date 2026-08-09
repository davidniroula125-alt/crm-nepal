<?php namespace App\Controllers;

use App\Models\Deal;
use App\Models\Invoice;
use App\Models\Contact;

class Reports extends BaseController
{
    public function index()
    {
        $companyId = $this->session->get('user')['company_id'];
        
        $dealModel = new Deal();
        $invoiceModel = new Invoice();
        $contactModel = new Contact();
        
        $deals = $dealModel->where('company_id', $companyId)->findAll();
        
        $dealsByStage = [];
        $stageValues = [];
        foreach ($deals as $deal) {
            $stage = $deal['stage'];
            $dealsByStage[$stage] = ($dealsByStage[$stage] ?? 0) + 1;
            $stageValues[$stage] = ($stageValues[$stage] ?? 0) + (float)$deal['value'];
        }
        
        $dealsByMonth = [];
        foreach ($deals as $deal) {
            $month = date('Y-m', strtotime($deal['created_at']));
            $dealsByMonth[$month] = ($dealsByMonth[$month] ?? 0) + 1;
        }
        ksort($dealsByMonth);
        
        $invoicesByStatus = [];
        $invoices = $invoiceModel->where('company_id', $companyId)->findAll();
        foreach ($invoices as $invoice) {
            $invoicesByStatus[$invoice['status']] = ($invoicesByStatus[$invoice['status']] ?? 0) + 1;
        }
        
        $contactsByStatus = [];
        $contacts = $contactModel->where('company_id', $companyId)->findAll();
        foreach ($contacts as $contact) {
            $contactsByStatus[$contact['status']] = ($contactsByStatus[$contact['status']] ?? 0) + 1;
        }
        
        usort($contacts, function($a, $b) {
            return (float)$b['value'] - (float)$a['value'];
        });
        $topContacts = array_slice($contacts, 0, 10);
        
        return view('pages/reports', [
            'dealsByStage' => $dealsByStage,
            'stageValues' => $stageValues,
            'dealsByMonth' => $dealsByMonth,
            'invoicesByStatus' => $invoicesByStatus,
            'contactsByStatus' => $contactsByStatus,
            'topContacts' => $topContacts,
        ]);
    }
}

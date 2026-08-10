<?php

namespace App\Controllers\Admin;

use App\Models\LeadModel;
use App\Models\ClientModel;
use App\Models\PaymentModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

class Reports extends BaseController
{
    protected $leadModel;
    protected $clientModel;
    protected $paymentModel;
    protected $subscriptionModel;
    protected $userModel;

    public function __construct()
    {
        $this->leadModel        = new LeadModel();
        $this->clientModel      = new ClientModel();
        $this->paymentModel     = new PaymentModel();
        $this->subscriptionModel = new SubscriptionModel();
        $this->userModel        = new UserModel();
    }

    /**
     * Date range helper: returns [startDate, endDate] from GET params or defaults.
     */
    protected function getDateRange(): array
    {
        $endDate   = $this->request->getGet('end_date') ?: date('Y-m-d');
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-d', strtotime('-30 days'));

        return [$startDate, $endDate];
    }

    /**
     * Reports overview page with links to each report type.
     */
    public function index()
    {
        return view('admin/reports/index', [
            'pageTitle' => 'Reports',
        ]);
    }

    /**
     * Lead analytics with date range filter.
     */
    public function leadReport()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $endDateTime = $endDate . ' 23:59:59';

        // Total leads in period
        $totalLeads = $this->leadModel
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->countAllResults(false);

        // Leads by status
        $statusCounts = $this->leadModel
            ->select('status, COUNT(*) as count')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->groupBy('status')
            ->get()
            ->getResult();

        $statusLabels = [];
        $statusData   = [];
        foreach ($statusCounts as $row) {
            $statusLabels[] = $row->status;
            $statusData[]   = (int) $row->count;
        }

        // Leads by source
        $sourceCounts = $this->leadModel
            ->select('source, COUNT(*) as count')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->groupBy('source')
            ->orderBy('count', 'DESC')
            ->get()
            ->getResult();

        $sourceLabels = [];
        $sourceData   = [];
        foreach ($sourceCounts as $row) {
            $sourceLabels[] = $row->source;
            $sourceData[]   = (int) $row->count;
        }

        // Leads over time (daily)
        $dailyLeads = $this->leadModel
            ->select("TO_CHAR(created_at, 'YYYY-MM-DD') as day, COUNT(*) as count")
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get()
            ->getResult();

        $timeLabels = [];
        $timeData   = [];
        foreach ($dailyLeads as $row) {
            $timeLabels[] = date('M d', strtotime($row->day));
            $timeData[]   = (int) $row->count;
        }

        // Leads in period for table
        $leads = $this->leadModel
            ->select('leads.*, users.name as assigned_to_name')
            ->join('users', 'users.id = leads.assigned_to', 'left')
            ->where('leads.created_at >=', $startDate)
            ->where('leads.created_at <=', $endDateTime)
            ->orderBy('leads.id', 'DESC')
            ->limit(100)
            ->get()
            ->getResult();

        return view('admin/reports/leads', [
            'pageTitle'     => 'Lead Report',
            'startDate'     => $startDate,
            'endDate'       => $endDate,
            'totalLeads'    => $totalLeads,
            'statusLabels'  => $statusLabels,
            'statusData'    => $statusData,
            'sourceLabels'  => $sourceLabels,
            'sourceData'    => $sourceData,
            'timeLabels'    => $timeLabels,
            'timeData'      => $timeData,
            'leads'         => $leads,
        ]);
    }

    /**
     * Sales/pipeline analytics with date range.
     */
    public function salesReport()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $endDateTime = $endDate . ' 23:59:59';

        // Total leads converted in period
        $converted = $this->leadModel
            ->where('status', 'Converted')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->countAllResults(false);

        // Total leads in period
        $total = $this->leadModel
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->countAllResults(false);

        $conversionRate = $total > 0 ? round(($converted / $total) * 100, 1) : 0;

        // Conversions over time (daily)
        $dailyConversions = $this->leadModel
            ->select("TO_CHAR(created_at, 'YYYY-MM-DD') as day, COUNT(*) as count")
            ->where('status', 'Converted')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get()
            ->getResult();

        $conversionLabels = [];
        $conversionData   = [];
        foreach ($dailyConversions as $row) {
            $conversionLabels[] = date('M d', strtotime($row->day));
            $conversionData[]   = (int) $row->count;
        }

        // Pipeline value by status
        $statusCounts = $this->leadModel
            ->select('status, COUNT(*) as count')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->groupBy('status')
            ->get()
            ->getResult();

        $pipelineLabels = [];
        $pipelineData   = [];
        foreach ($statusCounts as $row) {
            $pipelineLabels[] = $row->status;
            $pipelineData[]   = (int) $row->count;
        }

        // Converted leads in period
        $leads = $this->leadModel
            ->select('leads.*, users.name as assigned_to_name')
            ->join('users', 'users.id = leads.assigned_to', 'left')
            ->where('leads.status', 'Converted')
            ->where('leads.created_at >=', $startDate)
            ->where('leads.created_at <=', $endDateTime)
            ->orderBy('leads.id', 'DESC')
            ->limit(100)
            ->get()
            ->getResult();

        return view('admin/reports/sales', [
            'pageTitle'         => 'Sales Report',
            'startDate'         => $startDate,
            'endDate'           => $endDate,
            'totalLeads'        => $total,
            'convertedLeads'    => $converted,
            'conversionRate'    => $conversionRate,
            'conversionLabels'  => $conversionLabels,
            'conversionData'    => $conversionData,
            'pipelineLabels'    => $pipelineLabels,
            'pipelineData'      => $pipelineData,
            'leads'             => $leads,
        ]);
    }

    /**
     * Revenue analytics with date range.
     */
    public function revenueReport()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $endDateTime = $endDate . ' 23:59:59';

        // Total revenue (paid payments)
        $totalRevenue = (float) $this->paymentModel
            ->selectSum('amount')
            ->where('status', 'Paid')
            ->where('paid_at >=', $startDate)
            ->where('paid_at <=', $endDateTime)
            ->get()
            ->getRow()
            ->amount ?? 0;

        // Revenue by plan
        $planRevenue = $this->paymentModel
            ->select('subscriptions.plan_name, SUM(payments.amount) as total')
            ->join('subscriptions', 'subscriptions.id = payments.subscription_id', 'left')
            ->where('payments.status', 'Paid')
            ->where('payments.paid_at >=', $startDate)
            ->where('payments.paid_at <=', $endDateTime)
            ->groupBy('subscriptions.plan_name')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResult();

        $planLabels = [];
        $planData   = [];
        foreach ($planRevenue as $row) {
            $planLabels[] = $row->plan_name ?? 'Unassigned';
            $planData[]   = (float) $row->total;
        }

        // Revenue over time (daily)
        $dailyRevenue = $this->paymentModel
            ->select("TO_CHAR(paid_at, 'YYYY-MM-DD') as day, SUM(amount) as total")
            ->where('status', 'Paid')
            ->where('paid_at >=', $startDate)
            ->where('paid_at <=', $endDateTime)
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get()
            ->getResult();

        $revenueLabels = [];
        $revenueData   = [];
        foreach ($dailyRevenue as $row) {
            $revenueLabels[] = date('M d', strtotime($row->day));
            $revenueData[]   = (float) $row->total;
        }

        // Monthly average
        $startDt   = new \DateTime($startDate);
        $endDt     = new \DateTime($endDate);
            $daysDiff = $startDt->diff($endDt)->days + 1;
        $months    = max(1, $daysDiff / 30);
        $monthlyAvg = round($totalRevenue / $months, 2);

        return view('admin/reports/revenue', [
            'pageTitle'      => 'Revenue Report',
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'totalRevenue'   => $totalRevenue,
            'monthlyAvg'     => $monthlyAvg,
            'planLabels'     => $planLabels,
            'planData'       => $planData,
            'revenueLabels'  => $revenueLabels,
            'revenueData'    => $revenueData,
        ]);
    }

    /**
     * Payment analytics.
     */
    public function paymentReport()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $endDateTime = $endDate . ' 23:59:59';

        // Payment status breakdown
        $totalPaid = $this->paymentModel
            ->where('status', 'Paid')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->countAllResults(false);

        $totalPending = $this->paymentModel
            ->where('status', 'Pending')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->countAllResults(false);

        $totalOverdue = $this->paymentModel
            ->where('status', 'Overdue')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->countAllResults(false);

        $totalPartial = $this->paymentModel
            ->where('status', 'Partial')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->countAllResults(false);

        $totalCollected = (float) $this->paymentModel
            ->selectSum('amount')
            ->where('status', 'Paid')
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->get()
            ->getRow()
            ->amount ?? 0;

        // Payments over time (daily)
        $dailyPayments = $this->paymentModel
            ->select("TO_CHAR(created_at, 'YYYY-MM-DD') as day, SUM(amount) as total, COUNT(*) as count")
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get()
            ->getResult();

        $paymentLabels  = [];
        $paymentAmounts = [];
        $paymentCounts  = [];
        foreach ($dailyPayments as $row) {
            $paymentLabels[]  = date('M d', strtotime($row->day));
            $paymentAmounts[] = (float) $row->total;
            $paymentCounts[]  = (int) $row->count;
        }

        // Payments in period for table
        $payments = $this->paymentModel
            ->select('payments.*, clients.company_name, clients.contact_name')
            ->join('clients', 'clients.id = payments.client_id', 'left')
            ->where('payments.created_at >=', $startDate)
            ->where('payments.created_at <=', $endDateTime)
            ->orderBy('payments.id', 'DESC')
            ->limit(100)
            ->get()
            ->getResult();

        return view('admin/reports/payments', [
            'pageTitle'       => 'Payment Report',
            'startDate'       => $startDate,
            'endDate'         => $endDate,
            'totalCollected'  => $totalCollected,
            'totalPaid'       => $totalPaid,
            'totalPending'    => $totalPending,
            'totalOverdue'    => $totalOverdue,
            'totalPartial'    => $totalPartial,
            'statusLabels'    => ['Paid', 'Pending', 'Overdue', 'Partial'],
            'statusData'      => [$totalPaid, $totalPending, $totalOverdue, $totalPartial],
            'paymentLabels'   => $paymentLabels,
            'paymentAmounts'  => $paymentAmounts,
            'paymentCounts'   => $paymentCounts,
            'payments'        => $payments,
        ]);
    }

    /**
     * Client analytics.
     */
    public function clientReport()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $endDateTime = $endDate . ' 23:59:59';

        $totalClients = $this->clientModel->countAllResults();

        $activeClients = $this->clientModel
            ->where('status', 'Active')
            ->countAllResults(false);

        $inactiveClients = $this->clientModel
            ->where('status', 'Inactive')
            ->countAllResults(false);

        $newClients = $this->clientModel
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->countAllResults(false);

        // Status breakdown
        $statusCounts = $this->clientModel
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->getResult();

        $statusLabels = [];
        $statusData   = [];
        foreach ($statusCounts as $row) {
            $statusLabels[] = ucfirst($row->status);
            $statusData[]   = (int) $row->count;
        }

        // Clients over time (daily)
        $dailyClients = $this->clientModel
            ->select("TO_CHAR(created_at, 'YYYY-MM-DD') as day, COUNT(*) as count")
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->groupBy('day')
            ->orderBy('day', 'ASC')
            ->get()
            ->getResult();

        $clientLabels = [];
        $clientData   = [];
        foreach ($dailyClients as $row) {
            $clientLabels[] = date('M d', strtotime($row->day));
            $clientData[]   = (int) $row->count;
        }

        // Clients in period for table
        $clients = $this->clientModel
            ->where('created_at >=', $startDate)
            ->where('created_at <=', $endDateTime)
            ->orderBy('id', 'DESC')
            ->limit(100)
            ->get()
            ->getResult();

        return view('admin/reports/clients', [
            'pageTitle'      => 'Client Report',
            'startDate'      => $startDate,
            'endDate'        => $endDate,
            'totalClients'   => $totalClients,
            'activeClients'  => $activeClients,
            'inactiveClients'=> $inactiveClients,
            'newClients'     => $newClients,
            'statusLabels'   => $statusLabels,
            'statusData'     => $statusData,
            'clientLabels'   => $clientLabels,
            'clientData'     => $clientData,
            'clients'        => $clients,
        ]);
    }

    /**
     * Staff performance analytics.
     */
    public function staffReport()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $endDateTime = $endDate . ' 23:59:59';

        // Get all sales/admin users
        $staff = $this->userModel
            ->where('role !=', 'support')
            ->where('is_active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        $staffPerformance = [];

        foreach ($staff as $member) {
            $leadsAssigned = $this->leadModel
                ->where('assigned_to', $member->id)
                ->where('leads.created_at >=', $startDate)
                ->where('leads.created_at <=', $endDateTime)
                ->countAllResults(false);

            $leadsConverted = $this->leadModel
                ->where('assigned_to', $member->id)
                ->where('status', 'Converted')
                ->where('leads.created_at >=', $startDate)
                ->where('leads.created_at <=', $endDateTime)
                ->countAllResults(false);

            $conversionRate = $leadsAssigned > 0 ? round(($leadsConverted / $leadsAssigned) * 100, 1) : 0;

            $revenue = (float) $this->paymentModel
                ->selectSum('amount')
                ->join('clients', 'clients.id = payments.client_id', 'left')
                ->join('leads', 'leads.id = clients.lead_id', 'left')
                ->where('leads.assigned_to', $member->id)
                ->where('payments.status', 'Paid')
                ->where('payments.created_at >=', $startDate)
                ->where('payments.created_at <=', $endDateTime)
                ->get()
                ->getRow()
                ->amount ?? 0;

            $staffPerformance[] = [
                'name'            => $member->name,
                'leadsAssigned'   => $leadsAssigned,
                'leadsConverted'  => $leadsConverted,
                'conversionRate'  => $conversionRate,
                'revenue'         => $revenue,
            ];
        }

        // Chart data
        $staffNames  = array_column($staffPerformance, 'name');
        $assignedArr = array_column($staffPerformance, 'leadsAssigned');
        $convertedArr = array_column($staffPerformance, 'leadsConverted');
        $revenueArr  = array_column($staffPerformance, 'revenue');

        return view('admin/reports/staff', [
            'pageTitle'         => 'Staff Performance',
            'startDate'         => $startDate,
            'endDate'           => $endDate,
            'staffPerformance'  => $staffPerformance,
            'staffNames'        => $staffNames,
            'assignedData'      => $assignedArr,
            'convertedData'     => $convertedArr,
            'revenueData'       => $revenueArr,
        ]);
    }
}

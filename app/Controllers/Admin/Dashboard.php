<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Models\ActivityLogModel;

class Dashboard extends BaseController
{
    protected UserModel $userModel;
    protected ActivityLogModel $activityModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->activityModel = new ActivityLogModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        // ── Leads KPIs ──
        $totalLeads      = $db->table('leads')->countAllResults();
        $newLeads        = $db->table('leads')->where('status', 'New')->countAllResults();
        $qualifiedLeads  = $db->table('leads')->where('status', 'Qualified')->countAllResults();
        $convertedLeads  = $db->table('leads')->where('status', 'Converted')->countAllResults();

        // ── Clients KPIs ──
        $totalClients    = $db->table('clients')->countAllResults();
        $activeClients   = $db->table('clients')->where('status', 'Active')->countAllResults();
        $inactiveClients = $db->table('clients')->where('status', 'Inactive')->countAllResults();

        // ── Inquiries KPIs ──
        $totalInquiries  = $db->table('contact_inquiries')->countAllResults();
        $newInquiries    = $db->table('contact_inquiries')->where('status', 'New')->countAllResults();

        // ── Follow-ups ──
        $pendingFollowUps = $db->table('follow_ups')
            ->where('status', 'Pending')
            ->where('due_at >=', date('Y-m-d H:i:s'))
            ->countAllResults();

        // ── Demo Requests ──
        $upcomingDemos = $db->table('demo_requests')
            ->whereIn('status', ['Pending', 'Scheduled'])
            ->countAllResults();

        // ── Payments KPIs ──
        $totalRevenue = (float) ($db->table('payments')
            ->where('status', 'Paid')
            ->selectSum('amount')
            ->get()->getRow()->amount ?? 0);

        $revenueThisMonth = (float) ($db->table('payments')
            ->where('status', 'Paid')
            ->where('paid_at >=', date('Y-m-01 00:00:00'))
            ->where('paid_at <=', date('Y-m-t 23:59:59'))
            ->selectSum('amount')
            ->get()->getRow()->amount ?? 0);

        $paymentReceived = $db->table('payments')->where('status', 'Paid')->countAllResults();
        $paymentPending  = $db->table('payments')->where('status', 'Pending')->countAllResults();
        $overduePayments = $db->table('payments')->where('status', 'Overdue')->countAllResults();

        // ── Subscriptions KPIs ──
        $activeSubscriptions = $db->table('subscriptions')->where('status', 'Active')->countAllResults();
        $expiringSubscriptions = $db->table('subscriptions')
            ->groupStart()
                ->where('status', 'Expiring')
                ->orWhere('end_date <=', date('Y-m-d', strtotime('+30 days')))
            ->groupEnd()
            ->where('status !=', 'Expired')
            ->countAllResults();

        // ── Support Tickets KPIs ──
        $totalTickets = $db->table('support_tickets')->countAllResults();
        $openTickets  = $db->table('support_tickets')->where('status', 'Open')->countAllResults();

        // ── Recent Activities (last 10) ──
        $recentActivities = $db->table('activity_logs')
            ->select('activity_logs.*, users.name as user_name')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->orderBy('activity_logs.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResult();

        // ── Latest Leads (last 5) ──
        $latestLeads = $db->table('leads')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // ── Latest Clients (last 5) ──
        $latestClients = $db->table('clients')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // ── Latest Payments (last 5) ──
        $latestPayments = $db->table('payments')
            ->select('payments.*, clients.company_name, clients.contact_name')
            ->join('clients', 'clients.id = payments.client_id', 'left')
            ->orderBy('payments.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // ── Latest Inquiries (last 5) ──
        $latestInquiries = $db->table('contact_inquiries')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        // ── Chart: Leads by Status ──
        $leadsByStatus = $db->table('leads')
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->getResult();
        $leadStatusLabels = [];
        $leadStatusCounts = [];
        foreach ($leadsByStatus as $row) {
            $leadStatusLabels[] = $row->status;
            $leadStatusCounts[] = (int) $row->count;
        }

        // ── Chart: Leads by Source ──
        $leadsBySource = $db->table('leads')
            ->select('source, COUNT(*) as count')
            ->groupBy('source')
            ->orderBy('count', 'DESC')
            ->get()
            ->getResult();
        $leadSourceLabels = [];
        $leadSourceCounts = [];
        foreach ($leadsBySource as $row) {
            $leadSourceLabels[] = $row->source;
            $leadSourceCounts[] = (int) $row->count;
        }

        // ── Chart: Monthly Revenue (last 12 months) ──
        $monthlyRevenueLabels = [];
        $monthlyRevenueData   = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthStart = date('Y-m-01', strtotime("-{$i} months"));
            $monthEnd   = date('Y-m-t 23:59:59', strtotime("-{$i} months"));
            $monthlyRevenueLabels[] = date('M Y', strtotime("-{$i} months"));

            $amount = (float) ($db->table('payments')
                ->where('status', 'Paid')
                ->where('paid_at >=', $monthStart)
                ->where('paid_at <=', $monthEnd)
                ->selectSum('amount')
                ->get()->getRow()->amount ?? 0);

            $monthlyRevenueData[] = $amount;
        }

        $data = [
            'pageTitle' => 'Dashboard',

            // Leads
            'totalLeads'     => $totalLeads,
            'newLeads'       => $newLeads,
            'qualifiedLeads' => $qualifiedLeads,
            'convertedLeads' => $convertedLeads,

            // Clients
            'totalClients'    => $totalClients,
            'activeClients'   => $activeClients,
            'inactiveClients' => $inactiveClients,

            // Inquiries
            'totalInquiries' => $totalInquiries,
            'newInquiries'   => $newInquiries,

            // Follow-ups & Demos
            'pendingFollowUps' => $pendingFollowUps,
            'upcomingDemos'    => $upcomingDemos,

            // Revenue
            'totalRevenue'      => $totalRevenue,
            'revenueThisMonth'  => $revenueThisMonth,
            'paymentReceived'   => $paymentReceived,
            'paymentPending'    => $paymentPending,
            'overduePayments'   => $overduePayments,

            // Subscriptions
            'activeSubscriptions'   => $activeSubscriptions,
            'expiringSubscriptions' => $expiringSubscriptions,

            // Support
            'totalTickets' => $totalTickets,
            'openTickets'  => $openTickets,

            // Recent lists
            'recentActivities' => $recentActivities,
            'latestLeads'      => $latestLeads,
            'latestClients'    => $latestClients,
            'latestPayments'   => $latestPayments,
            'latestInquiries'  => $latestInquiries,

            // Chart data
            'leadStatusLabels' => $leadStatusLabels,
            'leadStatusCounts' => $leadStatusCounts,
            'leadSourceLabels' => $leadSourceLabels,
            'leadSourceCounts' => $leadSourceCounts,
            'monthlyRevenueLabels' => $monthlyRevenueLabels,
            'monthlyRevenueData'   => $monthlyRevenueData,
        ];

        return view('admin/dashboard/index', $data);
    }
}

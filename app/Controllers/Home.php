<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = $this->siteData([
            'metaTitle'       => 'CRM Software Nepal | Powerful CRM for Travel & Trekking Agencies',
            'metaDescription' => 'CRM Software Nepal helps travel agencies, trekking agencies, tour operators and DMCs manage leads, customers, bookings, payments and follow-ups in one place.',

            // TBD: replace with real figures before launch
            'trustStats' => [
                ['label' => 'Agencies Onboarded', 'value' => '50+', 'tbd' => true],
                ['label' => 'Years of Experience', 'value' => '5+', 'tbd' => true],
                ['label' => 'Leads Managed', 'value' => '10,000+', 'tbd' => true],
                ['label' => 'Uptime', 'value' => '99.9%', 'tbd' => true],
            ],

            'painPoints' => [
                'Customer data scattered across Excel sheets and notebooks',
                'Follow-ups missed because there is no reminder system',
                'Inquiries lost between phone, email, Facebook and WhatsApp',
                'No single view of a customer\'s travel and payment history',
                'Sales staff performance impossible to track or report on',
                'Outstanding payments and reminders tracked manually',
                'No visibility into which lead sources actually convert',
                'Owners have no real-time dashboard of business health',
                'Handover between staff loses context on a lead or client',
                'Reporting takes hours of manual spreadsheet work each month',
            ],

            'featureGroups' => [
                [
                    'title' => 'Lead Management',
                    'icon'  => 'target',
                    'items' => ['Capture from every channel', 'Automatic assignment', 'Status & source tracking', 'Follow-up scheduling', 'Lead-to-customer conversion'],
                ],
                [
                    'title' => 'Customer Management',
                    'icon'  => 'users',
                    'items' => ['Centralized customer database', 'Full profiles & contact info', 'Travel history', 'Communication log'],
                ],
                [
                    'title' => 'Sales Management',
                    'icon'  => 'trending-up',
                    'items' => ['Visual sales pipeline', 'Opportunity tracking', 'Follow-ups & activities', 'Staff performance reports'],
                ],
                [
                    'title' => 'Inquiry Management',
                    'icon'  => 'inbox',
                    'items' => ['Website, phone & email inquiries', 'Social media inquiries', 'Manual entry', 'Central inquiry inbox'],
                ],
                [
                    'title' => 'Tour / Travel Management',
                    'icon'  => 'map',
                    'items' => ['Packages & trip details', 'Traveler requirements', 'Travel dates & headcount', 'Destination tracking'],
                ],
                [
                    'title' => 'Payment Management',
                    'icon'  => 'credit-card',
                    'items' => ['Record payments', 'Track outstanding balances', 'Payment history', 'Automated reminders & receipts'],
                ],
                [
                    'title' => 'Reporting',
                    'icon'  => 'bar-chart-2',
                    'items' => ['Sales & lead reports', 'Customer reports', 'Revenue & payment reports', 'Staff performance reports'],
                ],
            ],

            'howItWorks' => [
                ['step' => 1, 'title' => 'Capture Inquiry', 'desc' => 'Every inquiry — website, phone, email, or social — lands in one inbox.'],
                ['step' => 2, 'title' => 'Assign Rep', 'desc' => 'Leads route automatically to the right salesperson.'],
                ['step' => 3, 'title' => 'Follow Up', 'desc' => 'Scheduled reminders keep every lead warm.'],
                ['step' => 4, 'title' => 'Convert to Customer', 'desc' => 'One click turns a qualified lead into a client record.'],
                ['step' => 5, 'title' => 'Manage Relationship', 'desc' => 'Bookings, payments and history stay in one place going forward.'],
            ],

            // TBD: replace placeholders with real product screenshots
            'screenshots' => [
                'Dashboard Overview', 'Lead Management', 'Customer Profile',
                'Sales Pipeline', 'Follow-up Calendar', 'Reports', 'Payments', 'User Management',
            ],
        ]);

        return view('pages/home', $data);
    }
}

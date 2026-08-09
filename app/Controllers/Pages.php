<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\ContactInquiryModel;
use App\Models\DemoRequestModel;
use App\Models\FaqModel;
use App\Models\LeadModel;
use App\Models\PricingPlanModel;

class Pages extends BaseController
{
    public function about(): string
    {
        return view('pages/about', $this->siteData([
            'metaTitle' => 'About Us | CRM Software Nepal',
        ]));
    }

    public function features(): string
    {
        return view('pages/features', $this->siteData([
            'metaTitle' => 'Features | CRM Software Nepal',
        ]));
    }

    public function solutions(): string
    {
        return view('pages/solutions', $this->siteData([
            'metaTitle' => 'Solutions | CRM Software Nepal',
        ]));
    }

    public function pricing(): string
    {
        $model = model(PricingPlanModel::class);
        $plans = $model->getActivePlans();

        return view('pages/pricing', $this->siteData([
            'metaTitle' => 'Pricing | CRM Software Nepal',
            'plans'     => $plans,
        ]));
    }

    public function faq(): string
    {
        $model     = model(FaqModel::class);
        $faqs      = $model->where('is_published', 1)->orderBy('sort_order', 'ASC')->findAll();
        $grouped   = [];
        $categories = [];
        foreach ($faqs as $faq) {
            $cat = $faq->category ?: 'General';
            $grouped[$cat][] = $faq;
            if (! in_array($cat, $categories, true)) {
                $categories[] = $cat;
            }
        }

        return view('pages/faq', $this->siteData([
            'metaTitle'  => 'FAQ | CRM Software Nepal',
            'grouped'    => $grouped,
            'categories' => $categories,
        ]));
    }

    public function contact(): string
    {
        return view('pages/contact', $this->siteData([
            'metaTitle' => 'Contact Us | CRM Software Nepal',
        ]));
    }

    public function contactSubmit()
    {
        $rules = [
            'name'    => 'required|min_length[2]|max_length[100]',
            'company' => 'permit_empty|max_length[150]',
            'email'   => 'required|valid_email',
            'phone'   => 'permit_empty|max_length[30]',
            'subject' => 'required|max_length[150]',
            'message' => 'required|min_length[5]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = model(ContactInquiryModel::class);
        $id = $model->insert([
            'name'       => $this->request->getPost('name'),
            'company'    => $this->request->getPost('company'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'subject'    => $this->request->getPost('subject'),
            'message'    => $this->request->getPost('message'),
            'status'     => 'new',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if ($id) {
            $log = model(ActivityLogModel::class);
            $log->log(0, 'contact_inquiry_created', 'ContactInquiry', $id);
        }

        return redirect()->to('/contact-us')->with('success', 'Thanks for reaching out — our team will get back to you shortly.');
    }

    public function demo(): string
    {
        return view('pages/demo', $this->siteData([
            'metaTitle' => 'Request a Demo | CRM Software Nepal',
        ]));
    }

    public function demoSubmit()
    {
        $rules = [
            'full_name'         => 'required|min_length[2]|max_length[100]',
            'company_name'      => 'required|max_length[150]',
            'email'             => 'required|valid_email',
            'phone'             => 'required|max_length[30]',
            'address'           => 'permit_empty|max_length[255]',
            'employee_count'    => 'permit_empty|max_length[30]',
            'current_software'  => 'permit_empty|max_length[150]',
            'business_type'     => 'required',
            'preferred_date'    => 'permit_empty|valid_date',
            'preferred_time'    => 'permit_empty|max_length[20]',
            'message'           => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Auto-create lead first
        $leadModel  = model(LeadModel::class);
        $leadId = $leadModel->insert([
            'full_name'    => $this->request->getPost('full_name'),
            'company_name' => $this->request->getPost('company_name'),
            'email'        => $this->request->getPost('email'),
            'phone'        => $this->request->getPost('phone'),
            'source'       => 'Demo Request',
            'status'       => 'New',
            'notes'        => 'Auto-created from demo request. Business type: ' . $this->request->getPost('business_type'),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        // Save demo request linked to the lead
        $demoModel = model(DemoRequestModel::class);
        $demoId = $demoModel->insert([
            'full_name'        => $this->request->getPost('full_name'),
            'company_name'     => $this->request->getPost('company_name'),
            'email'            => $this->request->getPost('email'),
            'phone'            => $this->request->getPost('phone'),
            'address'          => $this->request->getPost('address'),
            'employee_count'   => $this->request->getPost('employee_count'),
            'current_software' => $this->request->getPost('current_software'),
            'business_type'    => $this->request->getPost('business_type'),
            'preferred_date'   => $this->request->getPost('preferred_date'),
            'preferred_time'   => $this->request->getPost('preferred_time'),
            'message'          => $this->request->getPost('message'),
            'lead_id'          => $leadId,
            'status'           => 'pending',
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

        if ($demoId) {
            $log = model(ActivityLogModel::class);
            $log->log(0, 'demo_request_created', 'DemoRequest', $demoId);
            if ($leadId) {
                $log->log(0, 'lead_created_from_demo', 'Lead', $leadId);
            }
        }

        return redirect()->to('/request-a-demo')->with('success', 'Your demo request has been received. Our team will contact you to confirm the schedule.');
    }

    public function privacy(): string
    {
        return view('pages/legal', $this->siteData(['metaTitle' => 'Privacy Policy | CRM Software Nepal', 'legalTitle' => 'Privacy Policy']));
    }

    public function terms(): string
    {
        return view('pages/legal', $this->siteData(['metaTitle' => 'Terms & Conditions | CRM Software Nepal', 'legalTitle' => 'Terms & Conditions']));
    }

    public function refund(): string
    {
        return view('pages/legal', $this->siteData(['metaTitle' => 'Refund Policy | CRM Software Nepal', 'legalTitle' => 'Refund Policy']));
    }

    public function cookies(): string
    {
        return view('pages/legal', $this->siteData(['metaTitle' => 'Cookie Policy | CRM Software Nepal', 'legalTitle' => 'Cookie Policy']));
    }
}

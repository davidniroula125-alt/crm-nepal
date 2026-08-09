<?php

namespace App\Controllers;

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
        return view('pages/coming_soon', $this->siteData([
            'metaTitle' => 'Features | CRM Software Nepal',
            'pageTitle' => 'Features',
            'note'      => 'Full features page (deep-dive per module) — next build pass.',
        ]));
    }

    public function solutions(): string
    {
        return view('pages/coming_soon', $this->siteData([
            'metaTitle' => 'Solutions | CRM Software Nepal',
            'pageTitle' => 'Solutions',
            'note'      => 'Solutions-by-business-type page (Travel Agencies / Trekking / Tour Operators / DMCs) — next build pass.',
        ]));
    }

    public function pricing(): string
    {
        return view('pages/coming_soon', $this->siteData([
            'metaTitle' => 'Pricing | CRM Software Nepal',
            'pageTitle' => 'Pricing',
            'note'      => 'Monthly/Annual admin-editable pricing table — depends on Content CMS in Part 2.',
        ]));
    }

    public function faq(): string
    {
        return view('pages/coming_soon', $this->siteData([
            'metaTitle' => 'FAQ | CRM Software Nepal',
            'pageTitle' => 'Frequently Asked Questions',
            'note'      => 'Categorized, CMS-managed FAQ — depends on FaqModel + admin CMS in Part 2.',
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

        // TODO (next pass): save to `contact_inquiries` table via ContactInquiryModel,
        // notify admin, send auto-confirmation email to sender.

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

        // TODO (next pass):
        // 1. Save to `demo_requests` table
        // 2. Auto-create a lead (source = "Demo Request")
        // 3. Notify admin (email + in-app alert)
        // 4. Send confirmation email to prospect
        // 5. Auto-create a follow-up task assigned to sales

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

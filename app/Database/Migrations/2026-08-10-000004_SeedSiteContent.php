<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SeedSiteContent extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        $data = [
            // ── HOME PAGE ──
            ['slug' => 'home', 'section' => 'hero', 'key' => 'headline', 'value' => 'Powerful CRM Software for Travel Agencies in Nepal', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'hero', 'key' => 'subtext', 'value' => 'One platform to capture leads, manage customers, run your sales pipeline, track payments and report on your whole travel business — built for Nepal\'s travel, trekking and tour operators.', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'hero', 'key' => 'cta_primary', 'value' => 'Request a Demo', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'hero', 'key' => 'cta_primary_link', 'value' => '/request-a-demo', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'hero', 'key' => 'cta_secondary', 'value' => 'Explore Features', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'hero', 'key' => 'cta_secondary_link', 'value' => '/features', 'type' => 'text'],

            ['slug' => 'home', 'section' => 'problems', 'key' => 'headline', 'value' => 'Running a travel agency without a CRM looks like this', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'problems', 'key' => 'subtext', 'value' => 'Sound familiar? Here\'s what CRM Software Nepal replaces.', 'type' => 'text'],

            ['slug' => 'home', 'section' => 'features', 'key' => 'headline', 'value' => 'Everything your team needs, in one CRM', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'features', 'key' => 'subtext', 'value' => 'Purpose-built modules for every step of the customer journey.', 'type' => 'text'],

            ['slug' => 'home', 'section' => 'how_it_works', 'key' => 'headline', 'value' => 'How It Works', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'how_it_works', 'key' => 'subtext', 'value' => 'From first inquiry to repeat customer — in five simple steps.', 'type' => 'text'],

            ['slug' => 'home', 'section' => 'cta_band', 'key' => 'headline', 'value' => 'See CRM Software Nepal on your own data', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'cta_band', 'key' => 'subtext', 'value' => 'Book a free walkthrough with our team — no commitment required.', 'type' => 'text'],
            ['slug' => 'home', 'section' => 'cta_band', 'key' => 'cta_text', 'value' => 'Request a Demo', 'type' => 'text'],

            // ── ABOUT PAGE ──
            ['slug' => 'about', 'section' => 'hero', 'key' => 'headline', 'value' => 'About CRM Software Nepal', 'type' => 'text'],
            ['slug' => 'about', 'section' => 'who_we_are', 'key' => 'content', 'value' => 'CRM Software Nepal builds purpose-made customer relationship management software for Nepal\'s travel, trekking and tour operator businesses — replacing scattered spreadsheets with one connected system for leads, customers, bookings and payments.', 'type' => 'textarea'],
            ['slug' => 'about', 'section' => 'vision', 'key' => 'content', 'value' => 'To be the standard CRM platform for every travel and trekking business in Nepal.', 'type' => 'textarea'],
            ['slug' => 'about', 'section' => 'mission', 'key' => 'content', 'value' => 'To give travel agencies the tools to never lose a lead, never miss a follow-up, and always know the health of their business.', 'type' => 'textarea'],
            ['slug' => 'about', 'section' => 'why_us', 'key' => 'content', 'value' => 'Built specifically for the travel industry\'s workflow — inquiries, itineraries, traveler counts, seasonal follow-ups and payment tracking — rather than adapted from a generic CRM.', 'type' => 'textarea'],

            // ── FEATURES PAGE ──
            ['slug' => 'features', 'section' => 'hero', 'key' => 'headline', 'value' => 'Powerful CRM Features for Travel Agencies', 'type' => 'text'],
            ['slug' => 'features', 'section' => 'hero', 'key' => 'subtext', 'value' => 'Everything your travel agency needs to capture leads, manage customers, close deals and grow.', 'type' => 'text'],

            ['slug' => 'features', 'section' => 'lead_management', 'key' => 'headline', 'value' => 'Lead Management', 'type' => 'text'],
            ['slug' => 'features', 'section' => 'lead_management', 'key' => 'description', 'value' => 'Capture leads from every channel and never let one fall through the cracks.', 'type' => 'textarea'],

            ['slug' => 'features', 'section' => 'customer_management', 'key' => 'headline', 'value' => 'Customer Management', 'type' => 'text'],
            ['slug' => 'features', 'section' => 'customer_management', 'key' => 'description', 'value' => '360-degree customer profiles with full travel history and communication logs.', 'type' => 'textarea'],

            ['slug' => 'features', 'section' => 'sales_management', 'key' => 'headline', 'value' => 'Sales Management', 'type' => 'text'],
            ['slug' => 'features', 'section' => 'sales_management', 'key' => 'description', 'value' => 'Visual sales pipeline with deal tracking and staff performance dashboards.', 'type' => 'textarea'],

            ['slug' => 'features', 'section' => 'inquiry_management', 'key' => 'headline', 'value' => 'Inquiry Management', 'type' => 'text'],
            ['slug' => 'features', 'section' => 'inquiry_management', 'key' => 'description', 'value' => 'Unified inbox for website, phone, email and social media inquiries.', 'type' => 'textarea'],

            ['slug' => 'features', 'section' => 'tour_management', 'key' => 'headline', 'value' => 'Tour / Travel Management', 'type' => 'text'],
            ['slug' => 'features', 'section' => 'tour_management', 'key' => 'description', 'value' => 'Package management, traveler details, destinations and calendar view.', 'type' => 'textarea'],

            ['slug' => 'features', 'section' => 'payment_management', 'key' => 'headline', 'value' => 'Payment Management', 'type' => 'text'],
            ['slug' => 'features', 'section' => 'payment_management', 'key' => 'description', 'value' => 'Invoicing, partial payments, reminders and payment tracking.', 'type' => 'textarea'],

            ['slug' => 'features', 'section' => 'reporting', 'key' => 'headline', 'value' => 'Reporting & Analytics', 'type' => 'text'],
            ['slug' => 'features', 'section' => 'reporting', 'key' => 'description', 'value' => 'Real-time dashboards, staff performance, revenue and custom reports.', 'type' => 'textarea'],

            // ── CONTACT PAGE ──
            ['slug' => 'contact', 'section' => 'hero', 'key' => 'headline', 'value' => 'Contact Us', 'type' => 'text'],
            ['slug' => 'contact', 'section' => 'hero', 'key' => 'subtext', 'value' => 'Questions about CRM Software Nepal? Send us a message.', 'type' => 'text'],

            // ── PRICING PAGE ──
            ['slug' => 'pricing', 'section' => 'hero', 'key' => 'headline', 'value' => 'Simple, Transparent Pricing', 'type' => 'text'],
            ['slug' => 'pricing', 'section' => 'hero', 'key' => 'subtext', 'value' => 'No hidden fees. No long-term contracts. Choose the plan that fits your agency.', 'type' => 'text'],

            // ── FAQ PAGE ──
            ['slug' => 'faq', 'section' => 'hero', 'key' => 'headline', 'value' => 'Frequently Asked Questions', 'type' => 'text'],
            ['slug' => 'faq', 'section' => 'hero', 'key' => 'subtext', 'value' => 'Find answers to common questions about CRM Software Nepal. Can\'t find what you\'re looking for? Contact us.', 'type' => 'text'],

            // ── SOLUTIONS PAGE ──
            ['slug' => 'solutions', 'section' => 'hero', 'key' => 'headline', 'value' => 'CRM Solutions for Every Travel Business', 'type' => 'text'],
            ['slug' => 'solutions', 'section' => 'hero', 'key' => 'subtext', 'value' => 'Whether you run a small trekking agency or a large DMC, CRM Software Nepal adapts to your workflow.', 'type' => 'text'],

            // ── SITE SETTINGS ──
            ['slug' => 'settings', 'section' => 'general', 'key' => 'site_name', 'value' => 'CRM Software Nepal', 'type' => 'text'],
            ['slug' => 'settings', 'section' => 'general', 'key' => 'site_tagline', 'value' => 'Powerful CRM for Travel & Trekking Agencies', 'type' => 'text'],
            ['slug' => 'settings', 'section' => 'general', 'key' => 'site_email', 'value' => 'info@crmsoftwarenepal.com', 'type' => 'text'],
            ['slug' => 'settings', 'section' => 'general', 'key' => 'site_phone', 'value' => '+977-1-4XXXXXX', 'type' => 'text'],
            ['slug' => 'settings', 'section' => 'general', 'key' => 'site_address', 'value' => 'Kathmandu, Nepal', 'type' => 'text'],
            ['slug' => 'settings', 'section' => 'footer', 'key' => 'company_description', 'value' => 'CRM Software Nepal helps travel agencies, trekking agencies, tour operators and DMCs manage leads, customers, bookings, payments and follow-ups in one place.', 'type' => 'textarea'],
            ['slug' => 'settings', 'section' => 'footer', 'key' => 'copyright', 'value' => 'CRM Software Nepal. All rights reserved.', 'type' => 'text'],

            // ── DEMO PAGE ──
            ['slug' => 'demo', 'section' => 'hero', 'key' => 'headline', 'value' => 'Request a Free Demo', 'type' => 'text'],
            ['slug' => 'demo', 'section' => 'hero', 'key' => 'subtext', 'value' => 'See how CRM Software Nepal can transform your travel business. Book a personalized walkthrough.', 'type' => 'text'],
        ];

        foreach ($data as $row) {
            $row['created_at'] = $now;
            $db->table('site_content')->insert($row);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        $db->table('site_content')->truncate();
    }
}

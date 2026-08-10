<?php

namespace App\Libraries;

use CodeIgniter\Database\Config;

class DatabaseInit
{
    private static bool $initialized = false;

    public static function reset(): void
    {
        self::$initialized = false;
    }

    /**
     * Auto-create all missing tables. Runs once per request.
     */
    public static function ensureTables(): void
    {
        if (self::$initialized) {
            return;
        }
        self::$initialized = true;

        try {
            $db = Config\Database::connect();

            $tables = [
                "CREATE TABLE IF NOT EXISTS activity_logs (
                    id SERIAL PRIMARY KEY,
                    user_id INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
                    action VARCHAR(150) NOT NULL,
                    subject_type VARCHAR(100) NULL,
                    subject_id INTEGER NULL,
                    ip_address VARCHAR(45) NULL,
                    device VARCHAR(255) NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS follow_ups (
                    id SERIAL PRIMARY KEY,
                    lead_id INTEGER NULL REFERENCES leads(id) ON DELETE CASCADE,
                    client_id INTEGER NULL REFERENCES clients(id) ON DELETE CASCADE,
                    assigned_to INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
                    title VARCHAR(200) NOT NULL,
                    notes TEXT NULL,
                    due_at TIMESTAMP NOT NULL,
                    status VARCHAR(20) NOT NULL DEFAULT 'Pending' CHECK (status IN ('Pending','Completed','Cancelled')),
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS site_content (
                    id SERIAL PRIMARY KEY,
                    slug VARCHAR(100) NOT NULL,
                    section VARCHAR(100) NOT NULL,
                    key VARCHAR(150) NOT NULL,
                    value TEXT NULL,
                    type VARCHAR(20) NOT NULL DEFAULT 'text',
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP NULL,
                    UNIQUE(slug, section, key)
                )",
                "CREATE TABLE IF NOT EXISTS complaints (
                    id SERIAL PRIMARY KEY,
                    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
                    subject VARCHAR(200) NOT NULL,
                    message TEXT NOT NULL,
                    admin_reply TEXT NULL,
                    status VARCHAR(20) NOT NULL DEFAULT 'Open' CHECK (status IN ('Open','In Progress','Replied','Closed')),
                    replied_at TIMESTAMP NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP NULL
                )",
                "CREATE TABLE IF NOT EXISTS pricing_plans (
                    id SERIAL PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    billing_cycle VARCHAR(10) NOT NULL CHECK (billing_cycle IN ('Monthly','Annual')),
                    price DECIMAL(10,2) NOT NULL,
                    description TEXT NULL,
                    features TEXT NULL,
                    is_active SMALLINT NOT NULL DEFAULT 1,
                    sort_order INTEGER NOT NULL DEFAULT 0,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                )",
            ];

            foreach ($tables as $sql) {
                $db->query($sql);
            }

            // Add replied_at column to complaints if missing
            try {
                $db->query("ALTER TABLE complaints ADD COLUMN IF NOT EXISTS replied_at TIMESTAMP NULL");
            } catch (\Throwable $e) {
                // Column may already exist or driver doesn't support IF NOT EXISTS for ALTER
            }

            // Seed default site_content if table is empty
            $count = $db->table('site_content')->countAllResults();
            if ($count === 0) {
                $now = date('Y-m-d H:i:s');
                $seeds = [
                    ['home', 'hero', 'headline', 'Nepal\'s #1 CRM Software for Travel Agencies', 'text', $now],
                    ['home', 'hero', 'subheadline', 'Streamline your leads, clients, payments and support — all in one place.', 'text', $now],
                    ['home', 'hero', 'cta_text', 'Get Started Free', 'text', $now],
                    ['home', 'hero', 'cta_link', '/request-a-demo', 'text', $now],
                    ['about', 'hero', 'headline', 'About CRM Software Nepal', 'text', $now],
                    ['about', 'hero', 'subheadline', 'We help travel agencies across Nepal grow their business with powerful CRM tools.', 'text', $now],
                    ['about', 'content', 'mission', 'To empower Nepal\'s travel industry with smart, affordable CRM solutions.', 'text', $now],
                    ['about', 'content', 'vision', 'To become the most trusted CRM platform for every travel business in Nepal.', 'text', $now],
                    ['contact', 'info', 'phone', '+977-1-4444444', 'text', $now],
                    ['contact', 'info', 'email', 'info@crmsoftwarenepal.com', 'text', $now],
                    ['contact', 'info', 'address', 'Kathmandu, Nepal', 'text', $now],
                    ['pricing', 'hero', 'headline', 'Simple, Transparent Pricing', 'text', $now],
                    ['pricing', 'hero', 'subheadline', 'Choose the plan that fits your business. No hidden fees.', 'text', $now],
                    ['features', 'hero', 'headline', 'Powerful Features for Your Business', 'text', $now],
                    ['features', 'hero', 'subheadline', 'Everything you need to manage leads, clients, and payments.', 'text', $now],
                ];
                foreach ($seeds as $s) {
                    $db->table('site_content')->insert([
                        'slug' => $s[0], 'section' => $s[1], 'key' => $s[2],
                        'value' => $s[3], 'type' => $s[4], 'created_at' => $s[5],
                    ]);
                }
            }

        } catch (\Throwable $e) {
            // Database not available — let controllers handle gracefully
        }
    }
}

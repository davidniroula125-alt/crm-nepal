<?php namespace Config;

use CodeIgniter\Database\Config;

class DatabaseSetup
{
    private static $initialized = false;

    public static function initialize(): void
    {
        if (self::$initialized) return;
        self::$initialized = true;
        $db = Config::connect();
        $result = $db->query("SELECT to_regclass('public.companies') AS exists");
        $row = $result->getRow();
        if ($row && $row->exists) return;
        self::createTables($db);
        self::seedData($db);
    }

    private static function createTables($db): void
    {
        $db->query("CREATE TABLE IF NOT EXISTS companies (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            plan VARCHAR(50) DEFAULT 'starter',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            company_id INTEGER,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            role VARCHAR(20) DEFAULT 'user',
            language VARCHAR(5) DEFAULT 'en',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS contacts (
            id SERIAL PRIMARY KEY,
            company_id INTEGER,
            name VARCHAR(255) NOT NULL,
            company_name VARCHAR(255),
            email VARCHAR(255),
            phone VARCHAR(50),
            status VARCHAR(50) DEFAULT 'lead',
            value DECIMAL(12,2) DEFAULT 0,
            last_contact_date DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS deals (
            id SERIAL PRIMARY KEY,
            company_id INTEGER,
            contact_id INTEGER,
            title VARCHAR(255) NOT NULL,
            stage VARCHAR(50) DEFAULT 'lead',
            value DECIMAL(12,2) DEFAULT 0,
            assigned_to INTEGER,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS invoices (
            id SERIAL PRIMARY KEY,
            company_id INTEGER,
            contact_id INTEGER,
            invoice_number VARCHAR(50) UNIQUE NOT NULL,
            amount DECIMAL(12,2) DEFAULT 0,
            vat_amount DECIMAL(12,2) DEFAULT 0,
            payment_method VARCHAR(50) DEFAULT 'bank_transfer',
            status VARCHAR(20) DEFAULT 'pending',
            due_date DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS support_messages (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255),
            email VARCHAR(255),
            subject VARCHAR(255),
            message TEXT,
            type VARCHAR(50) DEFAULT 'contact',
            status VARCHAR(50) DEFAULT 'unread',
            reply TEXT,
            user_id INTEGER,
            company_id INTEGER,
            replied_by INTEGER,
            replied_at TIMESTAMP,
            read_at TIMESTAMP,
            resolved_at TIMESTAMP,
            closed_at TIMESTAMP,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS activity_log (
            id SERIAL PRIMARY KEY,
            company_id INTEGER,
            user_id INTEGER,
            action VARCHAR(255),
            entity_type VARCHAR(100),
            entity_id INTEGER,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS login_attempts (
            id SERIAL PRIMARY KEY,
            ip_address VARCHAR(45),
            email VARCHAR(255),
            attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS login_sessions (
            id SERIAL PRIMARY KEY,
            user_id INTEGER,
            ip_address VARCHAR(45),
            user_agent TEXT,
            logged_in_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            logged_out_at TIMESTAMP
        )");

        $db->query("CREATE TABLE IF NOT EXISTS site_content (
            id SERIAL PRIMARY KEY,
            section VARCHAR(100) NOT NULL,
            key_name VARCHAR(100) NOT NULL,
            title VARCHAR(255),
            description TEXT,
            icon VARCHAR(255),
            sort_order INTEGER DEFAULT 0,
            is_active SMALLINT DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    private static function seedData($db): void
    {
        $pw = password_hash('password123', PASSWORD_DEFAULT);
        $now = date('Y-m-d H:i:s');

        $db->table('companies')->insertBatch([
            ['name' => 'Himalaya Tech Solutions', 'plan' => 'professional', 'created_at' => $now],
            ['name' => 'Everest Trading Co.', 'plan' => 'enterprise', 'created_at' => $now],
            ['name' => 'Kathmandu Digital', 'plan' => 'starter', 'created_at' => $now],
        ]);

        $db->table('users')->insertBatch([
            ['company_id' => 1, 'name' => 'David Niroula', 'email' => 'davidniroula25@gmail.com', 'password_hash' => $pw, 'role' => 'super_admin', 'language' => 'en', 'created_at' => $now],
            ['company_id' => 1, 'name' => 'Sita Sharma', 'email' => 'sita@example.com', 'password_hash' => $pw, 'role' => 'admin', 'language' => 'ne', 'created_at' => $now],
            ['company_id' => 1, 'name' => 'Ram Thapa', 'email' => 'ram@example.com', 'password_hash' => $pw, 'role' => 'team_member', 'language' => 'en', 'created_at' => $now],
            ['company_id' => 2, 'name' => 'Anita Gurung', 'email' => 'anita@example.com', 'password_hash' => $pw, 'role' => 'admin', 'language' => 'en', 'created_at' => $now],
            ['company_id' => 3, 'name' => 'Bikash Rai', 'email' => 'bikash@example.com', 'password_hash' => $pw, 'role' => 'user', 'language' => 'ne', 'created_at' => $now],
        ]);

        $db->table('contacts')->insertBatch([
            ['company_id' => 1, 'name' => 'Prakash Dahal', 'company_name' => 'Dahal Enterprises', 'email' => 'prakash@dahal.com', 'phone' => '+977-9841XXXXXX', 'status' => 'customer', 'value' => 150000, 'last_contact_date' => date('Y-m-d'), 'created_at' => $now],
            ['company_id' => 1, 'name' => 'Sunita Magar', 'company_name' => 'Magar Traders', 'email' => 'sunita@magar.com', 'phone' => '+977-9851XXXXXX', 'status' => 'active', 'value' => 85000, 'last_contact_date' => date('Y-m-d'), 'created_at' => $now],
            ['company_id' => 1, 'name' => 'Rajesh Adhikari', 'company_name' => 'Adhikari IT', 'email' => 'rajesh@adhikari.com', 'phone' => '+977-9841XXXXXX', 'status' => 'lead', 'value' => 250000, 'last_contact_date' => date('Y-m-d'), 'created_at' => $now],
            ['company_id' => 1, 'name' => 'Meena Shrestha', 'company_name' => 'Shrestha Foods', 'email' => 'meena@shrestha.com', 'phone' => '+977-9861XXXXXX', 'status' => 'prospect', 'value' => 60000, 'last_contact_date' => date('Y-m-d'), 'created_at' => $now],
            ['company_id' => 1, 'name' => 'Kiran Bista', 'company_name' => 'Bista Construction', 'email' => 'kiran@bista.com', 'phone' => '+977-9841XXXXXX', 'status' => 'customer', 'value' => 320000, 'last_contact_date' => date('Y-m-d'), 'created_at' => $now],
            ['company_id' => 1, 'name' => 'Gita Poudel', 'company_name' => 'Poudel Logistics', 'email' => 'gita@poudel.com', 'phone' => '+977-9851XXXXXX', 'status' => 'inactive', 'value' => 45000, 'last_contact_date' => date('Y-m-d'), 'created_at' => $now],
        ]);

        $db->table('deals')->insertBatch([
            ['company_id' => 1, 'contact_id' => 1, 'title' => 'Enterprise License Deal', 'stage' => 'negotiation', 'value' => 150000, 'assigned_to' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 1, 'contact_id' => 2, 'title' => 'Annual Subscription', 'stage' => 'proposals', 'value' => 85000, 'assigned_to' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 1, 'contact_id' => 3, 'title' => 'Custom CRM Setup', 'stage' => 'lead', 'value' => 250000, 'assigned_to' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 1, 'contact_id' => 5, 'title' => 'Team Plan Upgrade', 'stage' => 'closed_won', 'value' => 320000, 'assigned_to' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['company_id' => 1, 'contact_id' => 4, 'title' => 'Startup Package', 'stage' => 'closed_lost', 'value' => 60000, 'assigned_to' => 2, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $db->table('invoices')->insertBatch([
            ['company_id' => 1, 'contact_id' => 5, 'invoice_number' => 'INV-0001', 'amount' => 320000, 'vat_amount' => 41600, 'payment_method' => 'bank_transfer', 'status' => 'paid', 'due_date' => date('Y-m-d', strtotime('+30 days')), 'created_at' => $now],
            ['company_id' => 1, 'contact_id' => 1, 'invoice_number' => 'INV-0002', 'amount' => 150000, 'vat_amount' => 19500, 'payment_method' => 'esewa', 'status' => 'pending', 'due_date' => date('Y-m-d', strtotime('+15 days')), 'created_at' => $now],
            ['company_id' => 1, 'contact_id' => 2, 'invoice_number' => 'INV-0003', 'amount' => 85000, 'vat_amount' => 11050, 'payment_method' => 'khalti', 'status' => 'overdue', 'due_date' => date('Y-m-d', strtotime('-5 days')), 'created_at' => $now],
        ]);

        self::seedFeatures($db, $now);
    }

    private static function seedFeatures($db, $now): void
    {
        $db->table('site_content')->insertBatch([
            ['section' => 'features', 'key_name' => 'contacts', 'title' => 'Contact Management', 'description' => 'Organize all your contacts in one place. Track communication history, notes, and deal associations.', 'icon' => 'Contacts', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'features', 'key_name' => 'pipeline', 'title' => 'Deal Pipeline', 'description' => 'Visual kanban board to track deals through every stage. Drag and drop to update.', 'icon' => 'Pipeline', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'features', 'key_name' => 'invoices', 'title' => 'Invoice Management', 'description' => 'Create, send, and track invoices with automatic VAT calculation at 13%.', 'icon' => 'Invoice', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'features', 'key_name' => 'reports', 'title' => 'Reports & Analytics', 'description' => 'Comprehensive dashboards and charts to visualize your business performance.', 'icon' => 'Reports', 'sort_order' => 4, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'features', 'key_name' => 'support', 'title' => 'Support System', 'description' => 'Manage customer inquiries and complaints with a built-in ticketing system.', 'icon' => 'Support', 'sort_order' => 5, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'features', 'key_name' => 'users', 'title' => 'User Management', 'description' => 'Role-based access control with super admin, admin, team member, and user roles.', 'icon' => 'Users', 'sort_order' => 6, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'features', 'key_name' => 'bilingual', 'title' => 'Bilingual Interface', 'description' => 'Switch between English and Nepali instantly. Use the language your team prefers.', 'icon' => 'Language', 'sort_order' => 7, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $db->table('site_content')->insertBatch([
            ['section' => 'local_features', 'key_name' => 'esewa', 'title' => 'eSewa Integration', 'description' => 'Send invoices directly to eSewa. Your customers can pay with their favorite digital wallet.', 'icon' => 'Payment', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'local_features', 'key_name' => 'khalti', 'title' => 'Khalti Support', 'description' => 'Accept payments through Khalti with one-click invoice links.', 'icon' => 'Payment', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'local_features', 'key_name' => 'vat', 'title' => 'VAT & PAN Compliance', 'description' => 'Automatic 13% VAT calculation on all invoices. PAN number support for tax filing.', 'icon' => 'Tax', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'local_features', 'key_name' => 'bilingual', 'title' => 'English & Nepali', 'description' => 'Full bilingual support. Your team can work in whichever language they are comfortable with.', 'icon' => 'Language', 'sort_order' => 4, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $db->table('site_content')->insertBatch([
            ['section' => 'faq', 'key_name' => 'free_trial', 'title' => 'Is there a free trial?', 'description' => 'Yes! We offer a 14-day free trial on all plans. No credit card required. Just sign up and start using CRM Nepal immediately.', 'icon' => '', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'faq', 'key_name' => 'payments', 'title' => 'What payment methods do you accept?', 'description' => 'We accept eSewa, Khalti, bank transfers, and credit/debit cards. All payments are processed in Nepali Rupees (NPR).', 'icon' => '', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['section' => 'faq', 'key_name' => 'data_security', 'title' => 'Is my data secure?', 'description' => 'Absolutely. We use bank-level encryption (SSL), regular backups, and secure cloud hosting. Your data is stored securely and never shared with third parties.', 'icon' => '', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

-- CRM Software Nepal — PostgreSQL schema
-- Run: psql -U postgres -d crm_software_nepal -f database/schema.sql

CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'sales' CHECK (role IN ('admin','editor','sales','support','user')),
    is_active SMALLINT NOT NULL DEFAULT 1,
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45) NULL,
    failed_login_attempts INTEGER NOT NULL DEFAULT 0,
    locked_until TIMESTAMP NULL,
    remember_token VARCHAR(255) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);

-- Leads table
CREATE TABLE IF NOT EXISTS leads (
    id SERIAL PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    company_name VARCHAR(150) NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(30) NULL,
    source VARCHAR(30) NOT NULL DEFAULT 'Website' CHECK (source IN ('Website','Facebook','Google','Referral','Phone','Email','Exhibition/Event','Existing Customer','Other','Demo Request')),
    status VARCHAR(20) NOT NULL DEFAULT 'New' CHECK (status IN ('New','Contacted','Qualified','Converted','Lost')),
    assigned_to INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
    notes TEXT NULL,
    next_follow_up_at TIMESTAMP NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);

-- Clients table
CREATE TABLE IF NOT EXISTS clients (
    id SERIAL PRIMARY KEY,
    lead_id INTEGER NULL REFERENCES leads(id) ON DELETE SET NULL,
    company_name VARCHAR(150) NOT NULL,
    contact_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(30) NULL,
    address VARCHAR(255) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Active' CHECK (status IN ('Active','Inactive')),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);

-- Demo Requests table
CREATE TABLE IF NOT EXISTS demo_requests (
    id SERIAL PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address VARCHAR(255) NULL,
    employee_count VARCHAR(30) NULL,
    current_software VARCHAR(150) NULL,
    business_type VARCHAR(50) NOT NULL,
    preferred_date DATE NULL,
    preferred_time VARCHAR(20) NULL,
    message TEXT NULL,
    lead_id INTEGER NULL REFERENCES leads(id) ON DELETE SET NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Pending' CHECK (status IN ('Pending','Scheduled','Completed','Cancelled')),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Contact Inquiries table
CREATE TABLE IF NOT EXISTS contact_inquiries (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    company VARCHAR(150) NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'New' CHECK (status IN ('New','Read','Responded')),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Subscriptions table
CREATE TABLE IF NOT EXISTS subscriptions (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL REFERENCES clients(id) ON DELETE CASCADE,
    plan_name VARCHAR(100) NOT NULL,
    billing_cycle VARCHAR(10) NOT NULL DEFAULT 'Monthly' CHECK (billing_cycle IN ('Monthly','Annual')),
    amount DECIMAL(10,2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Active' CHECK (status IN ('Active','Expiring','Expired','Cancelled')),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Payments table
CREATE TABLE IF NOT EXISTS payments (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL REFERENCES clients(id) ON DELETE CASCADE,
    subscription_id INTEGER NULL REFERENCES subscriptions(id) ON DELETE SET NULL,
    amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Pending' CHECK (status IN ('Paid','Pending','Overdue','Partial')),
    paid_at TIMESTAMP NULL,
    due_date DATE NULL,
    method VARCHAR(50) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Invoices table
CREATE TABLE IF NOT EXISTS invoices (
    id SERIAL PRIMARY KEY,
    payment_id INTEGER NOT NULL REFERENCES payments(id) ON DELETE CASCADE,
    invoice_number VARCHAR(50) NOT NULL UNIQUE,
    issued_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    pdf_path VARCHAR(255) NULL
);

-- Support Tickets table
CREATE TABLE IF NOT EXISTS support_tickets (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NULL REFERENCES clients(id) ON DELETE SET NULL,
    subject VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Open' CHECK (status IN ('Open','In Progress','Resolved','Closed')),
    assigned_to INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);

-- Testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
    id SERIAL PRIMARY KEY,
    client_name VARCHAR(150) NOT NULL,
    company VARCHAR(150) NULL,
    designation VARCHAR(100) NULL,
    profile_image VARCHAR(255) NULL,
    testimonial_text TEXT NOT NULL,
    star_rating SMALLINT NOT NULL DEFAULT 5,
    is_published SMALLINT NOT NULL DEFAULT 0,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- FAQs table
CREATE TABLE IF NOT EXISTS faqs (
    id SERIAL PRIMARY KEY,
    category VARCHAR(30) NOT NULL CHECK (category IN ('General','Pricing','Features','Security','Hosting','Data','Support','Subscription','Account','Implementation')),
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INTEGER NOT NULL DEFAULT 0,
    is_published SMALLINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Blog Categories table
CREATE TABLE IF NOT EXISTS blog_categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

-- Blog Posts table
CREATE TABLE IF NOT EXISTS blog_posts (
    id SERIAL PRIMARY KEY,
    category_id INTEGER NULL REFERENCES blog_categories(id) ON DELETE SET NULL,
    author_id INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    featured_image VARCHAR(255) NULL,
    excerpt VARCHAR(500) NULL,
    body TEXT NOT NULL,
    tags VARCHAR(255) NULL,
    seo_title VARCHAR(200) NULL,
    meta_description VARCHAR(300) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Draft' CHECK (status IN ('Draft','Published')),
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);

-- Pricing Plans table
CREATE TABLE IF NOT EXISTS pricing_plans (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    billing_cycle VARCHAR(10) NOT NULL CHECK (billing_cycle IN ('Monthly','Annual')),
    price DECIMAL(10,2) NOT NULL,
    description TEXT NULL,
    features TEXT NULL,
    is_active SMALLINT NOT NULL DEFAULT 1,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Activity Logs table
CREATE TABLE IF NOT EXISTS activity_logs (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
    action VARCHAR(150) NOT NULL,
    subject_type VARCHAR(100) NULL,
    subject_id INTEGER NULL,
    ip_address VARCHAR(45) NULL,
    device VARCHAR(255) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Follow-ups table
CREATE TABLE IF NOT EXISTS follow_ups (
    id SERIAL PRIMARY KEY,
    lead_id INTEGER NULL REFERENCES leads(id) ON DELETE CASCADE,
    client_id INTEGER NULL REFERENCES clients(id) ON DELETE CASCADE,
    assigned_to INTEGER NULL REFERENCES users(id) ON DELETE SET NULL,
    title VARCHAR(200) NOT NULL,
    notes TEXT NULL,
    due_at TIMESTAMP NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Pending' CHECK (status IN ('Pending','Completed','Cancelled')),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Complaints table
CREATE TABLE IF NOT EXISTS complaints (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    admin_reply TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Open' CHECK (status IN ('Open','In Progress','Replied','Closed')),
    replied_at TIMESTAMP NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);

-- Site Content table
CREATE TABLE IF NOT EXISTS site_content (
    id SERIAL PRIMARY KEY,
    slug VARCHAR(100) NOT NULL,
    section VARCHAR(100) NOT NULL,
    key VARCHAR(150) NOT NULL,
    value TEXT NULL,
    type VARCHAR(20) NOT NULL DEFAULT 'text',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    UNIQUE(slug, section, key)
);

-- Insert default admin user (password: Admin@123)
INSERT INTO users (name, email, password_hash, role, created_at) VALUES
('Administrator', 'admin@crmsoftwarenepal.com', '$2y$12$6Xxte0e5.5HbOAxN.JSDrur8VJBYx1oCBCKYV1JbqKcwwy8Om9l6a', 'admin', CURRENT_TIMESTAMP);

-- Insert default blog categories
INSERT INTO blog_categories (name, slug) VALUES
('CRM', 'crm'),
('Travel Technology', 'travel-technology'),
('Travel Business', 'travel-business'),
('Digital Transformation', 'digital-transformation'),
('Sales', 'sales'),
('Customer Management', 'customer-management'),
('Nepal Travel Industry', 'nepal-travel-industry'),
('Business Automation', 'business-automation');

-- Insert default pricing plans
INSERT INTO pricing_plans (name, billing_cycle, price, description, features, sort_order) VALUES
('Starter', 'Monthly', 2500.00, 'For small agencies getting started', 'Up to 5 users|Lead Management|Customer Database|Basic Reporting|Email Support', 1),
('Professional', 'Monthly', 5000.00, 'For growing travel businesses', 'Up to 15 users|Everything in Starter|Sales Pipeline|Payment Tracking|Follow-up Reminders|Priority Support', 2),
('Enterprise', 'Monthly', 10000.00, 'For large operations', 'Unlimited users|Everything in Professional|Advanced Reports|API Access|Custom Integrations|Dedicated Support', 3),
('Starter', 'Annual', 25000.00, 'For small agencies getting started', 'Up to 5 users|Lead Management|Customer Database|Basic Reporting|Email Support', 4),
('Professional', 'Annual', 50000.00, 'For growing travel businesses', 'Up to 15 users|Everything in Starter|Sales Pipeline|Payment Tracking|Follow-up Reminders|Priority Support', 5),
('Enterprise', 'Annual', 100000.00, 'For large operations', 'Unlimited users|Everything in Professional|Advanced Reports|API Access|Custom Integrations|Dedicated Support', 6);

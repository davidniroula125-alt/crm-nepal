-- CRM Software Nepal — base schema (Part 3 minimum table list)
-- NOT YET WIRED to models/migrations — reference schema for the next build pass.

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','sales','support') NOT NULL DEFAULT 'sales',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    last_login_at DATETIME NULL,
    last_login_ip VARCHAR(45) NULL,
    failed_login_attempts INT UNSIGNED NOT NULL DEFAULT 0,
    locked_until DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS leads (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    company_name VARCHAR(150) NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(30) NULL,
    source ENUM('Website','Facebook','Google','Referral','Phone','Email','Exhibition/Event','Existing Customer','Other','Demo Request') NOT NULL DEFAULT 'Website',
    status ENUM('New','Contacted','Qualified','Converted','Lost') NOT NULL DEFAULT 'New',
    assigned_to INT UNSIGNED NULL,
    notes TEXT NULL,
    next_follow_up_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS clients (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lead_id INT UNSIGNED NULL,
    company_name VARCHAR(150) NOT NULL,
    contact_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(30) NULL,
    address VARCHAR(255) NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (lead_id) REFERENCES leads(id)
);

CREATE TABLE IF NOT EXISTS demo_requests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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
    lead_id INT UNSIGNED NULL,
    status ENUM('Pending','Scheduled','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
    created_at DATETIME NOT NULL,
    FOREIGN KEY (lead_id) REFERENCES leads(id)
);

CREATE TABLE IF NOT EXISTS contact_inquiries (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    company VARCHAR(150) NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('New','Read','Responded') NOT NULL DEFAULT 'New',
    created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS subscriptions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED NOT NULL,
    plan_name VARCHAR(100) NOT NULL,
    billing_cycle ENUM('Monthly','Annual') NOT NULL DEFAULT 'Monthly',
    amount DECIMAL(10,2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('Active','Expiring','Expired','Cancelled') NOT NULL DEFAULT 'Active',
    created_at DATETIME NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE IF NOT EXISTS payments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED NOT NULL,
    subscription_id INT UNSIGNED NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('Paid','Pending','Overdue','Partial') NOT NULL DEFAULT 'Pending',
    paid_at DATETIME NULL,
    due_date DATE NULL,
    method VARCHAR(50) NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (subscription_id) REFERENCES subscriptions(id)
);

CREATE TABLE IF NOT EXISTS invoices (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    payment_id INT UNSIGNED NOT NULL,
    invoice_number VARCHAR(50) NOT NULL UNIQUE,
    issued_at DATETIME NOT NULL,
    pdf_path VARCHAR(255) NULL,
    FOREIGN KEY (payment_id) REFERENCES payments(id)
);

CREATE TABLE IF NOT EXISTS support_tickets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id INT UNSIGNED NULL,
    subject VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('Open','In Progress','Resolved','Closed') NOT NULL DEFAULT 'Open',
    assigned_to INT UNSIGNED NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (assigned_to) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS testimonials (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(150) NOT NULL,
    company VARCHAR(150) NULL,
    designation VARCHAR(100) NULL,
    profile_image VARCHAR(255) NULL,
    testimonial_text TEXT NOT NULL,
    star_rating TINYINT UNSIGNED NOT NULL DEFAULT 5,
    is_published TINYINT(1) NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS faqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category ENUM('General','Pricing','Features','Security','Hosting','Data','Support','Subscription','Account','Implementation') NOT NULL,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS blog_categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS blog_posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NULL,
    author_id INT UNSIGNED NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    featured_image VARCHAR(255) NULL,
    excerpt VARCHAR(500) NULL,
    body LONGTEXT NOT NULL,
    tags VARCHAR(255) NULL,
    seo_title VARCHAR(200) NULL,
    meta_description VARCHAR(300) NULL,
    status ENUM('Draft','Published') NOT NULL DEFAULT 'Draft',
    published_at DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id),
    FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS activity_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL,
    action VARCHAR(150) NOT NULL,
    subject_type VARCHAR(100) NULL,
    subject_id INT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    device VARCHAR(255) NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

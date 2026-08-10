<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($pageTitle ?? 'CRM Nepal Admin') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/theme.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body class="admin-body">

<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="<?= base_url('/admin/dashboard') ?>" class="sidebar-logo">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="CRM Nepal" height="30">
        </a>
        <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Close sidebar">&times;</button>
    </div>

    <nav class="sidebar-nav">
        <a href="<?= base_url('/admin/dashboard') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'dashboard' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9632;</span> Dashboard
        </a>

        <div class="sidebar-nav-label">CRM</div>
        <a href="<?= base_url('/admin/leads') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'leads' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9733;</span> Leads
        </a>
        <a href="<?= base_url('/admin/clients') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'clients' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9787;</span> Clients
        </a>
        <a href="<?= base_url('/admin/demo-requests') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'demo-requests' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9881;</span> Demo Requests
        </a>
        <a href="<?= base_url('/admin/contact-inquiries') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'contact-inquiries' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9993;</span> Contact Inquiries
        </a>

        <div class="sidebar-nav-label">Finance</div>
        <a href="<?= base_url('/admin/subscriptions') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'subscriptions' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#10003;</span> Subscriptions
        </a>
        <a href="<?= base_url('/admin/payments') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'payments' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#36;</span> Payments
        </a>

        <div class="sidebar-nav-label">Support</div>
        <a href="<?= base_url('/admin/support-tickets') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'support-tickets' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#128172;</span> Support Tickets
        </a>
        <a href="<?= base_url('/admin/complaints') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'complaints' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9888;</span> Complaints
        </a>

        <div class="sidebar-nav-label">Reports & Content</div>
        <a href="<?= base_url('/admin/reports') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'reports' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#128200;</span> Reports
        </a>
        <a href="<?= base_url('/admin/testimonials') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'testimonials' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9734;</span> Testimonials
        </a>
        <a href="<?= base_url('/admin/faqs') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'faqs' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#10067;</span> FAQs
        </a>
        <a href="<?= base_url('/admin/blog') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'blog' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9998;</span> Blog
        </a>

        <div class="sidebar-nav-label">Administration</div>
        <a href="<?= base_url('/admin/users') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'users' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9823;</span> Users
        </a>
        <a href="<?= base_url('/admin/site') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'site' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#127968;</span> Site Content
        </a>
        <a href="<?= base_url('/admin/logs') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'logs' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#128196;</span> Activity Logs
        </a>
        <a href="<?= base_url('/admin/settings') ?>" class="sidebar-link <?= (current_url(true)->getSegment(2) ?? '') === 'settings' ? 'active' : '' ?>">
            <span class="sidebar-icon">&#9881;</span> Settings
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= base_url('/') ?>" class="sidebar-link sidebar-home-link">
            <span class="sidebar-icon">&#8592;</span> Back to Homepage
        </a>
    </div>
</aside>

<div class="admin-content-wrapper" id="adminContentWrapper">
    <header class="admin-topbar">
        <div class="topbar-left">
            <button class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Toggle sidebar">&#9776;</button>
            <h1 class="topbar-title"><?= esc($pageTitle ?? 'Dashboard') ?></h1>
        </div>
        <div class="topbar-right">
            <span class="topbar-user-name"><?= esc(session()->get('user_name') ?? 'Admin') ?></span>
            <a href="<?= base_url('/admin/logout') ?>" class="topbar-logout-link">Logout</a>
        </div>
    </header>

    <main class="admin-main">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            <div class="alert alert-warning"><?= esc(session()->getFlashdata('warning')) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>
</div>

<script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>
</html>

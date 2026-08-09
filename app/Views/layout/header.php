<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'CRM Nepal') ?> - CRM Nepal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <rect width="32" height="32" rx="8" fill="url(#grad)"/>
                    <path d="M8 16L14 22L24 10" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs><linearGradient id="grad" x1="0" y1="0" x2="32" y2="32"><stop stop-color="#1E3A8A"/><stop offset="1" stop-color="#00E5FF"/></linearGradient></defs>
                </svg>
            </div>
            <span class="logo-text">CRM Nepal</span>
        </div>
        <nav class="sidebar-nav">
            <a href="/dashboard" class="nav-item <?= ($currentUrl ?? '') === '/dashboard' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="/contacts" class="nav-item <?= ($currentUrl ?? '') === '/contacts' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Contacts
            </a>
            <a href="/pipeline" class="nav-item <?= ($currentUrl ?? '') === '/pipeline' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                Pipeline
            </a>
            <a href="/invoices" class="nav-item <?= ($currentUrl ?? '') === '/invoices' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Invoices
            </a>
            <a href="/reports" class="nav-item <?= ($currentUrl ?? '') === '/reports' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Reports
            </a>
            <?php if (isStaff()): ?>
            <a href="/inquiries" class="nav-item <?= ($currentUrl ?? '') === '/inquiries' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                Inquiries
            </a>
            <?php endif; ?>
            <?php if (isAdmin()): ?>
            <a href="/content" class="nav-item <?= ($currentUrl ?? '') === '/content' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Content Manager
            </a>
            <?php endif; ?>
            <?php if (isSuperAdmin()): ?>
            <a href="/users" class="nav-item <?= ($currentUrl ?? '') === '/users' ? 'active' : '' ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/><path d="M12 6a2 2 0 1 0 2 2 2 2 0 0 0-2-2zm0 10a6 6 0 0 0-6-6h12a6 6 0 0 0-6 6z"/></svg>
                User Management
            </a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar"><?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?></div>
                <div class="user-details">
                    <span class="user-name"><?= esc($user['name'] ?? 'User') ?></span>
                    <span class="user-role"><?= esc(ucfirst(str_replace('_', ' ', $user['role'] ?? 'user'))) ?></span>
                </div>
            </div>
            <a href="/logout" class="logout-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </a>
        </div>
    </aside>
    <main class="main-content">
        <div class="content-header">
            <h1 class="page-title"><?= esc($title ?? 'Dashboard') ?></h1>
            <div class="header-actions"></div>
        </div>
        <div class="content-body">

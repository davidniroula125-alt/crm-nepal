<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Nepal - <?= esc($title ?? 'Login') ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="auth-body">
<div class="auth-layout">
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-logo">
                <svg width="48" height="48" viewBox="0 0 32 32" fill="none">
                    <rect width="32" height="32" rx="8" fill="url(#grad2)"/>
                    <path d="M8 16L14 22L24 10" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs><linearGradient id="grad2" x1="0" y1="0" x2="32" y2="32"><stop stop-color="#1E3A8A"/><stop offset="1" stop-color="#00E5FF"/></linearGradient></defs>
                </svg>
                <span>CRM Nepal</span>
            </div>
            <h1>Welcome to CRM Nepal</h1>
            <p>The all-in-one CRM platform designed for Nepali businesses. Manage contacts, track deals, and grow your business.</p>
            <div class="auth-features">
                <div class="auth-feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Contact Management</span>
                </div>
                <div class="auth-feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Deal Pipeline Tracking</span>
                </div>
                <div class="auth-feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Invoice & VAT Management</span>
                </div>
                <div class="auth-feature-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>Bilingual (English/Nepali)</span>
                </div>
            </div>
        </div>
    </div>
    <div class="auth-right">

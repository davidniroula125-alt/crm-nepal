<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// -----------------------------------------------------------------
// PART 1: PUBLIC FRONTEND (built in this pass)
// -----------------------------------------------------------------
$routes->get('/', 'Home::index');
$routes->get('about-us', 'Pages::about');
$routes->get('features', 'Pages::features');
$routes->get('solutions', 'Pages::solutions');
$routes->get('pricing', 'Pages::pricing');
$routes->get('faq', 'Pages::faq');
$routes->get('contact-us', 'Pages::contact');
$routes->post('contact-us', 'Pages::contactSubmit');
$routes->get('request-a-demo', 'Pages::demo');
$routes->post('request-a-demo', 'Pages::demoSubmit');

// Blog
$routes->get('blog', 'Blog::index');
$routes->get('blog/(:segment)', 'Blog::show/$1');
$routes->get('blog/category/(:segment)', 'Blog::category/$1');

// Legal
$routes->get('privacy-policy', 'Pages::privacy');
$routes->get('terms-and-conditions', 'Pages::terms');
$routes->get('refund-policy', 'Pages::refund');
$routes->get('cookie-policy', 'Pages::cookies');

// -----------------------------------------------------------------
// PART 2: ADMIN BACKEND
// -----------------------------------------------------------------
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {

    // ── Auth (public) ──
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::sendResetLink');
    $routes->get('reset-password', 'Auth::resetPassword');
    $routes->post('reset-password', 'Auth::updatePassword');

    // ── Protected admin routes ──
    $routes->group('', ['filter' => 'adminAuth'], function ($routes) {

        // Dashboard
        $routes->get('dashboard', 'Dashboard::index');

        // Leads
        $routes->get('leads', 'Leads::index');
        $routes->get('leads/create', 'Leads::create');
        $routes->post('leads/store', 'Leads::store');
        $routes->get('leads/(:num)', 'Leads::show/$1');
        $routes->get('leads/(:num)/edit', 'Leads::edit/$1');
        $routes->post('leads/(:num)/update', 'Leads::update/$1');
        $routes->post('leads/(:num)/delete', 'Leads::delete/$1');
        $routes->post('leads/(:num)/status', 'Leads::updateStatus/$1');

        // Clients
        $routes->get('clients', 'Clients::index');
        $routes->get('clients/create', 'Clients::create');
        $routes->post('clients/store', 'Clients::store');
        $routes->get('clients/(:num)', 'Clients::show/$1');
        $routes->get('clients/(:num)/edit', 'Clients::edit/$1');
        $routes->post('clients/(:num)/update', 'Clients::update/$1');
        $routes->post('clients/(:num)/delete', 'Clients::delete/$1');

        // Demo Requests
        $routes->get('demo-requests', 'DemoRequests::index');
        $routes->get('demo-requests/(:num)', 'DemoRequests::show/$1');
        $routes->post('demo-requests/(:num)/status', 'DemoRequests::updateStatus/$1');
        $routes->post('demo-requests/(:num)/delete', 'DemoRequests::delete/$1');

        // Contact Inquiries
        $routes->get('contact-inquiries', 'ContactInquiries::index');
        $routes->get('contact-inquiries/(:num)', 'ContactInquiries::show/$1');
        $routes->post('contact-inquiries/(:num)/status', 'ContactInquiries::updateStatus/$1');
        $routes->post('contact-inquiries/(:num)/delete', 'ContactInquiries::delete/$1');

        // Subscriptions
        $routes->get('subscriptions', 'Subscriptions::index');
        $routes->get('subscriptions/create', 'Subscriptions::create');
        $routes->post('subscriptions/store', 'Subscriptions::store');
        $routes->get('subscriptions/(:num)', 'Subscriptions::show/$1');
        $routes->get('subscriptions/(:num)/edit', 'Subscriptions::edit/$1');
        $routes->post('subscriptions/(:num)/update', 'Subscriptions::update/$1');
        $routes->post('subscriptions/(:num)/delete', 'Subscriptions::delete/$1');

        // Payments
        $routes->get('payments', 'Payments::index');
        $routes->get('payments/create', 'Payments::create');
        $routes->post('payments/store', 'Payments::store');
        $routes->get('payments/(:num)', 'Payments::show/$1');
        $routes->get('payments/(:num)/edit', 'Payments::edit/$1');
        $routes->post('payments/(:num)/update', 'Payments::update/$1');
        $routes->post('payments/(:num)/delete', 'Payments::delete/$1');
        $routes->post('payments/(:num)/mark-paid', 'Payments::markPaid/$1');

        // Support Tickets
        $routes->get('support-tickets', 'SupportTickets::index');
        $routes->get('support-tickets/create', 'SupportTickets::create');
        $routes->post('support-tickets/store', 'SupportTickets::store');
        $routes->get('support-tickets/(:num)', 'SupportTickets::show/$1');
        $routes->get('support-tickets/(:num)/edit', 'SupportTickets::edit/$1');
        $routes->post('support-tickets/(:num)/update', 'SupportTickets::update/$1');
        $routes->post('support-tickets/(:num)/delete', 'SupportTickets::delete/$1');
        $routes->post('support-tickets/(:num)/status', 'SupportTickets::updateStatus/$1');
        $routes->post('support-tickets/(:num)/assign', 'SupportTickets::assign/$1');

        // Reports
        $routes->get('reports', 'Reports::index');
        $routes->get('reports/leads', 'Reports::leadReport');
        $routes->get('reports/sales', 'Reports::salesReport');
        $routes->get('reports/revenue', 'Reports::revenueReport');
        $routes->get('reports/payments', 'Reports::paymentReport');
        $routes->get('reports/clients', 'Reports::clientReport');
        $routes->get('reports/staff', 'Reports::staffReport');

        // Testimonials
        $routes->get('testimonials', 'Testimonials::index');
        $routes->get('testimonials/create', 'Testimonials::create');
        $routes->post('testimonials/store', 'Testimonials::store');
        $routes->get('testimonials/(:num)', 'Testimonials::show/$1');
        $routes->get('testimonials/(:num)/edit', 'Testimonials::edit/$1');
        $routes->post('testimonials/(:num)/update', 'Testimonials::update/$1');
        $routes->post('testimonials/(:num)/delete', 'Testimonials::delete/$1');
        $routes->post('testimonials/(:num)/toggle-publish', 'Testimonials::togglePublish/$1');
        $routes->get('testimonials/(:num)/toggle-publish', 'Testimonials::togglePublish/$1');
        $routes->post('testimonials/(:num)/reorder', 'Testimonials::reorder/$1');

        // FAQs
        $routes->get('faqs', 'Faqs::index');
        $routes->get('faqs/create', 'Faqs::create');
        $routes->post('faqs/store', 'Faqs::store');
        $routes->get('faqs/(:num)', 'Faqs::show/$1');
        $routes->get('faqs/(:num)/edit', 'Faqs::edit/$1');
        $routes->post('faqs/(:num)/update', 'Faqs::update/$1');
        $routes->post('faqs/(:num)/delete', 'Faqs::delete/$1');
        $routes->post('faqs/(:num)/toggle-publish', 'Faqs::togglePublish/$1');
        $routes->get('faqs/(:num)/toggle-publish', 'Faqs::togglePublish/$1');

        // Blog
        $routes->get('blog', 'Blog::index');
        $routes->get('blog/create', 'Blog::create');
        $routes->post('blog/store', 'Blog::store');
        $routes->get('blog/(:num)', 'Blog::show/$1');
        $routes->get('blog/(:num)/edit', 'Blog::edit/$1');
        $routes->post('blog/(:num)/update', 'Blog::update/$1');
        $routes->post('blog/(:num)/delete', 'Blog::delete/$1');
        $routes->post('blog/(:num)/publish', 'Blog::publish/$1');
        $routes->post('blog/(:num)/unpublish', 'Blog::unpublish/$1');

        // Blog Categories
        $routes->get('blog/categories', 'BlogCategories::index');
        $routes->get('blog/categories/create', 'BlogCategories::create');
        $routes->post('blog/categories/store', 'BlogCategories::store');
        $routes->get('blog/categories/(:num)/edit', 'BlogCategories::edit/$1');
        $routes->post('blog/categories/(:num)/update', 'BlogCategories::update/$1');
        $routes->post('blog/categories/(:num)/delete', 'BlogCategories::delete/$1');

        // Users
        $routes->get('users', 'Users::index');
        $routes->get('users/create', 'Users::create');
        $routes->post('users/store', 'Users::store');
        $routes->get('users/(:num)', 'Users::show/$1');
        $routes->get('users/(:num)/edit', 'Users::edit/$1');
        $routes->post('users/(:num)/update', 'Users::update/$1');
        $routes->post('users/(:num)/delete', 'Users::delete/$1');
        $routes->post('users/(:num)/toggle-status', 'Users::toggleStatus/$1');

        // Settings
        $routes->get('settings', 'Settings::index');
        $routes->post('settings/update', 'Settings::update');
    });
});

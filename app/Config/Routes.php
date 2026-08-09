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
// PART 2: ADMIN BACKEND — NOT YET BUILT IN THIS PASS
// Reserved routes only. See README "Next Build Steps" for the plan.
// -----------------------------------------------------------------
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->get('logout', 'Auth::logout');

    $routes->group('', ['filter' => 'adminAuth'], function ($routes) {
        $routes->get('dashboard', 'Dashboard::index');
        // Leads, Clients, Subscriptions, Payments, Demo Requests, Pipeline,
        // Support Tickets, Users, Content CMS, Reports — to be added next.
    });
});

<?php
use CodeIgniter\Router\RouteCollection;

$routes = new RouteCollection($config);

$routes->get('/', 'Landing::index');
$routes->get('/login', 'Auth::login');
$routes->get('/signup', 'Auth::signup');
$routes->get('/logout', 'Auth::logout');
$routes->post('/login', 'Auth::doLogin');
$routes->post('/signup', 'Auth::doSignup');

$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/contacts', 'Contacts::index');
$routes->get('/contacts/create', 'Contacts::create');
$routes->post('/contacts/store', 'Contacts::store');
$routes->get('/contacts/edit/(:num)', 'Contacts::edit/$1');
$routes->post('/contacts/update/(:num)', 'Contacts::update/$1');
$routes->get('/contacts/delete/(:num)', 'Contacts::delete/$1');
$routes->get('/contacts/view/(:num)', 'Contacts::view/$1');
$routes->post('/contacts/search', 'Contacts::search');

$routes->get('/pipeline', 'Pipeline::index');
$routes->post('/pipeline/store', 'Pipeline::store');
$routes->post('/pipeline/update/(:num)', 'Pipeline::update/$1');
$routes->post('/pipeline/updateStage', 'Pipeline::updateStage');
$routes->get('/pipeline/delete/(:num)', 'Pipeline::delete/$1');

$routes->get('/invoices', 'Invoices::index');
$routes->get('/invoices/create', 'Invoices::create');
$routes->post('/invoices/store', 'Invoices::store');
$routes->get('/invoices/edit/(:num)', 'Invoices::edit/$1');
$routes->post('/invoices/update/(:num)', 'Invoices::update/$1');
$routes->get('/invoices/delete/(:num)', 'Invoices::delete/$1');

$routes->get('/inquiries', 'Inquiries::index');
$routes->post('/inquiries/reply/(:num)', 'Inquiries::reply/$1');
$routes->post('/inquiries/updateStatus/(:num)', 'Inquiries::updateStatus/$1');

$routes->get('/complaints', 'Complaints::index');
$routes->post('/complaints/store', 'Complaints::store');
$routes->post('/complaints/reply/(:num)', 'Complaints::reply/$1');
$routes->post('/complaints/updateStatus/(:num)', 'Complaints::updateStatus/$1');

$routes->get('/users', 'Users::index');
$routes->post('/users/store', 'Users::store');
$routes->post('/users/updateRole/(:num)', 'Users::updateRole/$1');
$routes->post('/users/delete/(:num)', 'Users::delete/$1');

$routes->get('/content', 'Content::index');
$routes->get('/content/create', 'Content::create');
$routes->post('/content/store', 'Content::store');
$routes->get('/content/edit/(:num)', 'Content::edit/$1');
$routes->post('/content/update/(:num)', 'Content::update/$1');
$routes->get('/content/delete/(:num)', 'Content::delete/$1');
$routes->post('/content/toggle/(:num)', 'Content::toggle/$1');

$routes->get('/reports', 'Reports::index');

$routes->get('/settings', 'Settings::index');
$routes->post('/settings/update', 'Settings::update');

$routes->get('/api/deals', 'Api::getDeals');
$routes->post('/api/chatbot-submit', 'Api::chatbotSubmit');

return $routes;

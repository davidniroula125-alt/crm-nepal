<?php

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Path to the root of the project
define('ROOTPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Ensure the system directory exists
if (!is_dir(ROOTPATH . 'system')) {
    die('system directory not found at ' . ROOTPATH . 'system');
}

// Load the framework bootstrap
require_once ROOTPATH . 'system' . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Auto-create database tables and seed data on first run
if (php_sapi_name() !== 'cli') {
    try {
        \Config\DatabaseSetup::initialize();
    } catch (\Throwable $e) {
        error_log('DatabaseSetup: ' . $e->getMessage());
    }
}

<?php

define('CI4_START', microtime(true));

$paths = [
    ROOTPATH,
    APPPATH,
    SYSDIR,
];

require_once ROOTPATH . 'system/bootstrap.php';

// Auto-create database tables and seed data on first run
if (php_sapi_name() !== 'cli') {
    try {
        \Config\DatabaseSetup::initialize();
    } catch (\Throwable $e) {
        // Silently fail if DB not available yet
        error_log('DatabaseSetup: ' . $e->getMessage());
    }
}

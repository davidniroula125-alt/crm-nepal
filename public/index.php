<?php

/*
 * --------------------------------------------------------------------
 * CRM Software Nepal — Front Controller (CodeIgniter 4)
 * --------------------------------------------------------------------
 * This is the standard CI4 entry point. Once `composer install` has
 * been run (which populates /vendor with the framework), all requests
 * are routed through here.
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

// Load our paths config file
require FCPATH . '../app/Config/Paths.php';

$paths = new Config\Paths();

// Location of the framework bootstrap file
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// Launch the application
$app = \Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);
exit($app->run());

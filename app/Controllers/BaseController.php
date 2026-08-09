<?php namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $session;
    protected $db;
    private static $dbInitialized = false;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = session();

        // Auto-create database tables on first request
        if (!self::$dbInitialized) {
            self::$dbInitialized = true;
            try {
                \Config\DatabaseSetup::initialize();
            } catch (\Throwable $e) {
                error_log('DatabaseSetup: ' . $e->getMessage());
            }
        }

        $this->db = \Config\Database::connect();
    }
}

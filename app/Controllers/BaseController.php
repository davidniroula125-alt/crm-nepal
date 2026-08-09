<?php namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $session;
    protected $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = session();
        $this->db = \Config\Database::connect();
    }

    protected function setTheme(string $title = 'CRM Nepal'): void
    {
        $data['title'] = $title;
        $data['user'] = $this->session->get('user');
        $data['currentUrl'] = service('uri')->getPath();
        return $data;
    }
}

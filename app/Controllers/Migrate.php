<?php

namespace App\Controllers;

use CodeIgniter\CLI\CLI;

class Migrate extends BaseController
{
    public function index()
    {
        $secret = $this->request->getGet('key');
        if ($secret !== 'crm-nepal-setup-2026') {
            return $this->response->setStatusCode(403)->setBody('Forbidden');
        }

        $migrator = \Config\Services::migrations();
        try {
            $migrator->latest();
            return $this->response->setBody('Migration completed successfully.');
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)->setBody('Migration failed: ' . $e->getMessage());
        }
    }
}

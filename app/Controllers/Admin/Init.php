<?php

namespace App\Controllers\Admin;

use App\Libraries\DatabaseInit;

class Init extends BaseController
{
    /**
     * Run database initialization — creates all missing tables.
     * Visit /admin/init in browser, then delete this file or disable in production.
     */
    public function index()
    {
        DatabaseInit::reset();
        DatabaseInit::ensureTables();

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Database tables initialized successfully. All tables created if they were missing.',
        ]);
    }
}

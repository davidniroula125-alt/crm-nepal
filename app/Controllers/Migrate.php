<?php

namespace App\Controllers;

class Migrate extends BaseController
{
    public function index()
    {
        $secret = $this->request->getGet('key');
        if ($secret !== 'crm-nepal-setup-2026') {
            return $this->response->setStatusCode(403)->setBody('Forbidden');
        }

        $db = \Config\Database::connect();
        $output = "";

        try {
            // Fix role constraint
            $db->query("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            $db->query("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin','editor','sales','support','user'))");
            $output .= "Role constraint updated.\n";
        } catch (\Throwable $e) {
            $output .= "Role constraint: " . $e->getMessage() . "\n";
        }

        try {
            // Create complaints table
            $db->query("CREATE TABLE IF NOT EXISTS complaints (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
                subject VARCHAR(200) NOT NULL,
                message TEXT NOT NULL,
                admin_reply TEXT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'Open' CHECK (status IN ('Open','In Progress','Replied','Closed')),
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL
            )");
            $output .= "Complaints table created.\n";
        } catch (\Throwable $e) {
            $output .= "Complaints table: " . $e->getMessage() . "\n";
        }

        // Verify
        $tables = $db->listTables();
        $output .= "\nAll tables: " . implode(', ', $tables) . "\n";

        return $this->response->setBody($output)->setHeader('Content-Type', 'text/plain');
    }
}

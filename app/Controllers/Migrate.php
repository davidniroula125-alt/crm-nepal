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
            // Reset admin password to Admin@123
            $hash = password_hash('Admin@123', PASSWORD_DEFAULT);
            $db->table('users')->where('email', 'admin@crmsoftwarenepal.com')->update(['password_hash' => $hash]);
            $output .= "Admin password reset to Admin@123. Rows affected: " . $db->affectedRows() . "\n";
        } catch (\Throwable $e) {
            $output .= "Password reset: " . $e->getMessage() . "\n";
        }

        try {
            // Verify admin user exists and has correct role
            $admin = $db->table('users')->where('email', 'admin@crmsoftwarenepal.com')->get()->getRow();
            if ($admin) {
                $output .= "Admin user found: id={$admin->id}, role={$admin->role}, active={$admin->is_active}\n";
                if ($admin->role !== 'admin') {
                    $db->table('users')->where('id', $admin->id)->update(['role' => 'admin']);
                    $output .= "Fixed admin role.\n";
                }
            } else {
                $output .= "Admin user NOT FOUND! Creating...\n";
                $db->table('users')->insert([
                    'name' => 'Administrator',
                    'email' => 'admin@crmsoftwarenepal.com',
                    'password_hash' => $hash,
                    'role' => 'admin',
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $output .= "Admin user created.\n";
            }
        } catch (\Throwable $e) {
            $output .= "Verify: " . $e->getMessage() . "\n";
        }

        return $this->response->setBody($output)->setHeader('Content-Type', 'text/plain');
    }
}

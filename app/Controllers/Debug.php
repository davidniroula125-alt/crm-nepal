<?php

namespace App\Controllers;

class Debug extends BaseController
{
    public function index()
    {
        $output = "PHP OK\n";
        $output .= "CI4 Version: " . \CodeIgniter\CodeIgniter::CI_VERSION . "\n";

        try {
            $db = \Config\Database::connect();
            $output .= "DB Connected: " . $db->getDatabase() . "\n";

            $tables = $db->listTables();
            $output .= "Tables: " . implode(', ', $tables) . "\n";
        } catch (\Throwable $e) {
            $output .= "DB Error: " . $e->getMessage() . "\n";
        }

        // Test if admin auth class loads
        try {
            $auth = new \App\Controllers\Admin\Auth();
            $output .= "Admin Auth class loaded OK\n";
        } catch (\Throwable $e) {
            $output .= "Admin Auth class error: " . $e->getMessage() . "\n";
        }

        // Test if admin BaseController loads
        try {
            $ref = new \ReflectionClass(\App\Controllers\Admin\BaseController::class);
            $output .= "Admin BaseController class loaded OK\n";
        } catch (\Throwable $e) {
            $output .= "Admin BaseController class error: " . $e->getMessage() . "\n";
        }

        // Test if ComplaintModel loads
        try {
            $model = new \App\Models\ComplaintModel();
            $output .= "ComplaintModel loaded OK\n";
        } catch (\Throwable $e) {
            $output .= "ComplaintModel error: " . $e->getMessage() . "\n";
        }

        return $this->response->setBody($output)->setHeader('Content-Type', 'text/plain');
    }
}

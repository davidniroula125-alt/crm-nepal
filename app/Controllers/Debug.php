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

        try {
            $classFile = APPPATH . 'Controllers/Admin/Auth.php';
            if (file_exists($classFile)) {
                $output .= "Admin/Auth.php exists: YES\n";
                $output .= "File size: " . filesize($classFile) . " bytes\n";
            } else {
                $output .= "Admin/Auth.php exists: NO\n";
            }
        } catch (\Throwable $e) {
            $output .= "File check error: " . $e->getMessage() . "\n";
        }

        // Check if autoloader finds classes
        try {
            $output .= "ComplaintModel class: " . (class_exists(\App\Models\ComplaintModel::class) ? 'YES' : 'NO') . "\n";
        } catch (\Throwable $e) {
            $output .= "Autoload error: " . $e->getMessage() . "\n";
        }

        try {
            $output .= "ActivityLogModel class: " . (class_exists(\App\Models\ActivityLogModel::class) ? 'YES' : 'NO') . "\n";
        } catch (\Throwable $e) {
            $output .= "Autoload error: " . $e->getMessage() . "\n";
        }

        return $this->response->setBody($output)->setHeader('Content-Type', 'text/plain');
    }
}

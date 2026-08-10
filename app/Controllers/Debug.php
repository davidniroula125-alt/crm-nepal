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

        return $this->response->setBody($output)->setHeader('Content-Type', 'text/plain');
    }
}

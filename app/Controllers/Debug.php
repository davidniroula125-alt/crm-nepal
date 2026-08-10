<?php

namespace App\Controllers;

class Debug extends BaseController
{
    public function index()
    {
        $output = "PHP OK\n";
        $output .= "CI4 Version: " . \CodeIgniter\CodeIgniter::CI_VERSION . "\n";
        $output .= "ENV: " . ENVIRONMENT . "\n";

        try {
            $db = \Config\Database::connect();
            $output .= "DB Connected: " . $db->getDatabase() . "\n";
            $tables = $db->listTables();
            $output .= "Tables (" . count($tables) . "): " . implode(', ', $tables) . "\n";
        } catch (\Throwable $e) {
            $output .= "DB Error: " . $e->getMessage() . "\n";
        }

        $output .= "\n--- Class Checks ---\n";
        $classes = [
            'Admin\\Auth'              => \App\Controllers\Admin\Auth::class,
            'Admin\\BaseController'    => \App\Controllers\Admin\BaseController::class,
            'Admin\\Test'              => \App\Controllers\Admin\Test::class,
            'Admin\\Dashboard'         => \App\Controllers\Admin\Dashboard::class,
            'Admin\\Users'             => \App\Controllers\Admin\Users::class,
            'Admin\\Complaints'        => \App\Controllers\Admin\Complaints::class,
            'Admin\\Logs'              => \App\Controllers\Admin\Logs::class,
            'UserAuth'                 => \App\Controllers\UserAuth::class,
            'UserDashboard'            => \App\Controllers\UserDashboard::class,
            'ComplaintController'      => \App\Controllers\ComplaintController::class,
            'ComplaintModel'           => \App\Models\ComplaintModel::class,
            'ActivityLogModel'         => \App\Models\ActivityLogModel::class,
            'AdminAuth Filter'         => \App\Filters\AdminAuth::class,
        ];

        foreach ($classes as $label => $fqcn) {
            try {
                $output .= "{$label}: " . (class_exists($fqcn) ? 'OK' : 'MISSING') . "\n";
            } catch (\Throwable $e) {
                $output .= "{$label}: ERROR - " . $e->getMessage() . "\n";
            }
        }

        $output .= "\n--- Route Info ---\n";
        try {
            $routes = \Config\Services::routes();
            $output .= "Route collection loaded OK\n";
        } catch (\Throwable $e) {
            $output .= "Route error: " . $e->getMessage() . "\n";
        }

        return $this->response->setBody($output)->setHeader('Content-Type', 'text/plain');
    }
}

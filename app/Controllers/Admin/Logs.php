<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;

class Logs extends BaseController
{
    public function index()
    {
        try {
            $logModel = new ActivityLogModel();

            $logModel->select('activity_logs.*, users.name as user_name');
            $logModel->join('users', 'users.id = activity_logs.user_id', 'left');
            $logModel->orderBy('activity_logs.created_at', 'DESC');

            $data = [];
            $data['logs']  = $logModel->paginate(50);
            $data['pager'] = $logModel->pager;

            return view('admin/logs/index', $data);
        } catch (\Throwable $e) {
            log_message('error', 'Logs index error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            return view('admin/logs/index', [
                'logs' => [],
                'pager' => null,
                'error' => 'Activity logs error: ' . $e->getMessage(),
            ]);
        }
    }
}

<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;

class Logs extends BaseController
{
    public function index()
    {
        $logModel = new ActivityLogModel();

        $builder = $logModel->builder();
        $builder->select('activity_logs.*, users.name as user_name');
        $builder->join('users', 'users.id = activity_logs.user_id', 'left');
        $builder->orderBy('activity_logs.created_at', 'DESC');
        $builder->limit(200);

        return view('admin/logs/index', [
            'logs' => $builder->get()->getResult(),
        ]);
    }
}

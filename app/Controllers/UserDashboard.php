<?php

namespace App\Controllers;

use App\Models\ComplaintModel;

class UserDashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        if (! $userId) {
            return redirect()->to('/user/login');
        }

        $complaintModel = new ComplaintModel();
        $complaints = $complaintModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        return view('user/dashboard', [
            'userName'   => session()->get('user_name'),
            'complaints' => $complaints,
        ]);
    }
}

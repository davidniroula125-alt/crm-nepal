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
        $totalComplaints   = $complaintModel->where('user_id', $userId)->countAllResults();
        $openComplaints    = $complaintModel->where('user_id', $userId)->where('status', 'Open')->countAllResults();
        $inProgressComplaints = $complaintModel->where('user_id', $userId)->where('status', 'In Progress')->countAllResults();
        $repliedComplaints = $complaintModel->where('user_id', $userId)->where('status', 'Replied')->countAllResults();
        $closedComplaints  = $complaintModel->where('user_id', $userId)->where('status', 'Closed')->countAllResults();
        $allComplaints     = $complaintModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        return view('user/dashboard', [
            'userName'            => session()->get('user_name'),
            'userEmail'           => session()->get('user_email'),
            'totalComplaints'     => $totalComplaints,
            'openComplaints'      => $openComplaints,
            'inProgressComplaints'=> $inProgressComplaints,
            'repliedComplaints'   => $repliedComplaints,
            'closedComplaints'    => $closedComplaints,
            'allComplaints'       => $allComplaints,
        ]);
    }
}

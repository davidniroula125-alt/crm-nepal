<?php

namespace App\Controllers;

use App\Models\ComplaintModel;

class ComplaintController extends BaseController
{
    public function submit()
    {
        $userId = session()->get('user_id');
        if (! $userId) {
            return redirect()->to('/user/login')->with('error', 'Please log in to submit a complaint.');
        }

        $rules = [
            'subject' => 'required|max_length[200]',
            'message' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $model = new ComplaintModel();
        $model->insert([
            'user_id'    => $userId,
            'subject'    => $this->request->getPost('subject'),
            'message'    => $this->request->getPost('message'),
            'status'     => 'Open',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/user/dashboard')->with('success', 'Complaint submitted successfully.');
    }
}

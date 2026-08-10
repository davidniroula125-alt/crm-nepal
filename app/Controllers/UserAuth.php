<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ActivityLogModel;
use App\Models\ComplaintModel;

class UserAuth extends BaseController
{
    public function showLogin()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/user/dashboard');
        }
        return view('user/login');
    }

    public function showSignup()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/user/dashboard');
        }
        return view('user/signup');
    }

    public function doLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (! $user || ! password_verify($password, $user->password_hash)) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        if (! $user->is_active) {
            return redirect()->back()->withInput()->with('error', 'Account deactivated.');
        }

        session()->set([
            'user_id'    => $user->id,
            'user_name'  => $user->name,
            'user_email' => $user->email,
            'user_role'  => $user->role,
        ]);

        $userModel->update($user->id, [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $this->request->getIPAddress(),
        ]);

        (new ActivityLogModel())->log($user->id, 'Logged in');

        if (in_array($user->role, ['admin', 'editor'])) {
            return redirect()->to('/admin/dashboard');
        }
        return redirect()->to('/user/dashboard');
    }

    public function doSignup()
    {
        $rules = [
            'name'     => 'required|min_length[2]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]|matches[password_confirm]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $userModel = new UserModel();
        $id = $userModel->insert([
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'user',
            'is_active'     => 1,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        if (! $id) {
            return redirect()->back()->withInput()->with('error', 'Could not create account.');
        }

        (new ActivityLogModel())->log($id, 'Account created');

        return redirect()->to('/user/login')->with('success', 'Account created! Please log in.');
    }

    public function doLogout()
    {
        $userId = session()->get('user_id');
        if ($userId) {
            (new ActivityLogModel())->log($userId, 'Logged out');
        }
        session()->destroy();
        return redirect()->to('/');
    }
}

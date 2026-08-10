<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Models\ActivityLogModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('admin/auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (! $user || ! password_verify($password, $user->password_hash)) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        if (! $user->is_active) {
            return redirect()->back()->withInput()->with('error', 'Account deactivated. Contact admin.');
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

        if ($user->role === 'admin' || $user->role === 'editor') {
            return redirect()->to('/admin/dashboard');
        }
        return redirect()->to('/user/dashboard');
    }

    public function logout()
    {
        $userId = session()->get('user_id');
        if ($userId) {
            (new ActivityLogModel())->log($userId, 'Logged out');
        }
        session()->destroy();
        return redirect()->to('/');
    }

    public function forgotPassword()
    {
        return view('admin/auth/forgot_password');
    }

    public function sendResetLink()
    {
        return redirect()->back()->with('success', 'If the email exists, a reset link has been sent.');
    }

    public function resetPassword()
    {
        return view('admin/auth/reset_password', ['token' => $this->request->getGet('token') ?? '']);
    }

    public function updatePassword()
    {
        return redirect()->to('/admin/login')->with('success', 'Password reset. You can now log in.');
    }
}

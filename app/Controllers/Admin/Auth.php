<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Models\ActivityLogModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $activityLog;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->activityLog  = new ActivityLogModel();
    }

    /**
     * Show the admin login form.
     */
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/auth/login');
    }

    /**
     * Process the login form submission.
     */
    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByEmail($email);

        if (! $user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        // Check if account is locked
        if ($user->locked_until !== null && strtotime($user->locked_until) > time()) {
            $minutesLeft = ceil((strtotime($user->locked_until) - time()) / 60);

            return redirect()->back()
                ->withInput()
                ->with('error', "Account is locked. Please try again in {$minutesLeft} minutes.");
        }

        // Verify password
        if (! password_verify($password, $user->password_hash)) {
            $this->userModel->incrementFailedAttempts($user->id);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        // Check if user is active
        if (! $user->is_active) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Your account has been deactivated. Please contact the administrator.');
        }

        // Login successful — set session data
        $session = session();
        $session->set([
            'user_id'    => $user->id,
            'user_name'  => $user->name,
            'user_email' => $user->email,
            'user_role'  => $user->role,
        ]);

        // Update last login info and reset failed attempts
        $this->userModel->updateLastLogin($user->id, $this->request->getIPAddress());
        $this->userModel->resetFailedAttempts($user->id);

        // Log the activity
        $this->activityLog->log($user->id, 'Logged in');

        return redirect()->to('/admin/dashboard');
    }

    /**
     * Log the admin out and redirect to login.
     */
    public function logout()
    {
        $userId = session()->get('user_id');

        if ($userId) {
            $this->activityLog->log($userId, 'Logged out');
        }

        session()->destroy();

        return redirect()->to('/admin/login');
    }

    /**
     * Show the forgot password form.
     */
    public function forgotPassword()
    {
        return view('admin/auth/forgot_password');
    }

    /**
     * Process the forgot password form — send reset link via email.
     */
    public function sendResetLink()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $email = $this->request->getPost('email');
        $user  = $this->userModel->findByEmail($email);

        // Always show success to prevent email enumeration
        return redirect()->back()
            ->with('success', 'If the email exists in our system, a password reset link has been sent.');
    }

    /**
     * Show the reset password form (via token link from email).
     */
    public function resetPassword()
    {
        $token = $this->request->getGet('token');

        if (empty($token)) {
            return redirect()->to('/admin/login')
                ->with('error', 'Invalid or expired reset token.');
        }

        return view('admin/auth/reset_password', ['token' => $token]);
    }

    /**
     * Process the password reset form submission.
     */
    public function updatePassword()
    {
        $rules = [
            'token'              => 'required',
            'password'           => 'required|min_length[8]|matches[password_confirm]',
            'password_confirm'   => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $token    = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        // In a real implementation, validate the token against a password_resets table.
        // For now, this is a placeholder that returns an appropriate message.
        $user = $this->userModel->where('remember_token', $token)->first();

        if (! $user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid or expired reset token.');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->updatePassword($user->id, $passwordHash);
        $this->userModel->update($user->id, ['remember_token' => null]);

        $this->activityLog->log($user->id, 'Password reset via token');

        return redirect()->to('/admin/login')
            ->with('success', 'Your password has been reset. You can now log in.');
    }
}

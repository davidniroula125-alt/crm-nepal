<?php namespace App\Controllers;

use App\Models\User;
use App\Models\LoginSession;
use App\Models\LoginAttempt;

class Users extends BaseController
{
    public function index()
    {
        if (!isSuperAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $userModel = new User();
        $loginSessionModel = new LoginSession();
        $loginAttemptModel = new LoginAttempt();
        
        $users = $userModel->findAll();
        $activeSessions = $loginSessionModel->getActiveSessions();
        $recentAttempts = $loginAttemptModel->orderBy('attempted_at', 'DESC')->limit(20)->findAll();
        
        return view('pages/users', [
            'users' => $users,
            'activeSessions' => $activeSessions,
            'recentAttempts' => $recentAttempts,
        ]);
    }

    public function store()
    {
        if (!isSuperAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $userModel = new User();
        
        $companyId = $this->session->get('user')['company_id'];
        $email = $this->request->getPost('email');
        
        if ($userModel->where('email', $email)->first()) {
            return redirect()->to('/users')->with('error', 'Email already exists');
        }
        
        $userId = $userModel->insert([
            'company_id' => $companyId,
            'name' => $this->request->getPost('name'),
            'email' => $email,
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role') ?: 'user',
            'language' => 'en',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        log_activity('user_created', 'user', $userId);
        
        return redirect()->to('/users');
    }

    public function updateRole($id)
    {
        if (!isSuperAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        $userModel = new User();
        $role = $this->request->getPost('role');
        
        $userModel->update($id, ['role' => $role]);
        log_activity('user_role_changed', 'user', $id);
        
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        if (!isSuperAdmin()) {
            return redirect()->to('/dashboard');
        }
        
        if ($id == $this->session->get('user_id')) {
            return redirect()->to('/users')->with('error', 'Cannot delete yourself');
        }
        
        $userModel = new User();
        $userModel->delete($id);
        log_activity('user_deleted', 'user', $id);
        
        return redirect()->to('/users');
    }
}

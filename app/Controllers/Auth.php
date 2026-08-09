<?php namespace App\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\LoginAttempt;
use App\Models\LoginSession;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->session->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login', ['error' => null]);
    }

    public function signup()
    {
        if ($this->session->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/signup', ['error' => null]);
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new User();
        $loginAttemptModel = new LoginAttempt();

        $loginAttemptModel->logAttempt($email);

        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return view('auth/login', ['error' => 'Invalid email or password']);
        }

        $sessionData = [
            'user_id' => $user['id'],
            'user' => $user,
        ];
        $this->session->set($sessionData);

        $loginSessionModel = new LoginSession();
        $loginSessionModel->insert([
            'user_id' => $user['id'],
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'logged_in_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/dashboard');
    }

    public function doSignup()
    {
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $companyName = $this->request->getPost('company_name');

        $userModel = new User();
        $companyModel = new Company();

        if ($userModel->where('email', $email)->first()) {
            return view('auth/signup', ['error' => 'Email already registered']);
        }

        $companyId = $companyModel->insert([
            'name' => $companyName,
            'plan' => 'starter',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $userId = $userModel->insert([
            'company_id' => $companyId,
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'admin',
            'language' => 'en',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $user = $userModel->find($userId);
        $this->session->set([
            'user_id' => $userId,
            'user' => $user,
        ]);

        log_activity('account_created', 'user', $userId);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}

<?php namespace App\Controllers;

use App\Models\User;

class Settings extends BaseController
{
    public function index()
    {
        return view('pages/settings');
    }

    public function update()
    {
        $userModel = new User();
        $userId = $this->session->get('user_id');
        
        $updateData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];
        
        if ($this->request->getPost('language')) {
            $updateData['language'] = $this->request->getPost('language');
        }
        
        if ($password = $this->request->getPost('password')) {
            $updateData['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        $userModel->update($userId, $updateData);
        
        $user = $userModel->find($userId);
        $this->session->set('user', $user);
        
        log_activity('profile_updated', 'user', $userId);
        
        return redirect()->to('/settings')->with('success', 'Profile updated successfully');
    }
}

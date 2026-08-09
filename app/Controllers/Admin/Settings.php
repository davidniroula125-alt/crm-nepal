<?php

namespace App\Controllers\Admin;

class Settings extends BaseController
{
    public function index(): string
    {
        $data = $this->currentUser();
        return view('admin/settings/index', [
            'user' => $data,
            'metaTitle' => 'Settings | CRM Nepal Admin',
        ]);
    }

    public function update()
    {
        $userId = $this->currentUser()->id;
        $userModel = model('UserModel');

        $post = $this->request->getPost();

        $rules = [
            'name' => 'required|min_length[2]|max_length[150]',
        ];

        if (! empty($post['new_password'])) {
            $rules['new_password'] = 'required|min_length[8]';
            $rules['confirm_password'] = 'required_with[new_password]|matches[new_password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = ['name' => $post['name']];

        if (! empty($post['new_password'])) {
            $updateData['password_hash'] = password_hash($post['new_password'], PASSWORD_BCRYPT);
        }

        $userModel->update($userId, $updateData);

        return redirect()->to('/admin/settings')->with('success', 'Settings updated successfully.');
    }
}

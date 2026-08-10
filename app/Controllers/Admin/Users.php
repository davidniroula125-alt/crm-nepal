<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $page   = max((int) ($this->request->getGet('page') ?? 1), 1);
        $perPage = 20;

        $users = $this->userModel->orderBy('id', 'DESC')->paginate($perPage, 'default', $page);
        $total = $this->userModel->countAllResults();

        $data = [
            'pageTitle' => 'Users',
            'users'     => $users,
            'pager'     => $this->userModel->pager,
            'total'     => $total,
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'Add New User',
        ];

        return view('admin/users/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'              => 'required|max_length[150]',
            'email'             => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'password'          => 'required|min_length[8]',
            'password_confirm'  => 'required|matches[password]',
            'role'              => 'required|in_list[admin,editor,sales,support,user]',
            'is_active'         => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'name'         => $this->request->getPost('name'),
            'email'        => $this->request->getPost('email'),
            'password_hash'=> password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'         => $this->request->getPost('role'),
            'is_active'    => (int) $this->request->getPost('is_active'),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        if (! $this->userModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', $this->userModel->errors()
                ? implode('<br>', $this->userModel->errors())
                : 'Failed to create user.');
        }

        return redirect()->to('/admin/users')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $data = [
            'pageTitle' => 'User Details',
            'user'      => $user,
        ];

        return view('admin/users/show', $data);
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $data = [
            'pageTitle' => 'Edit User',
            'user'      => $user,
        ];

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $rules = [
            'name'     => 'required|max_length[150]',
            'email'    => "required|valid_email|max_length[150]|is_unique[users.email,id,{$id}]",
            'role'     => 'required|in_list[admin,editor,sales,support,user]',
            'is_active'=> 'required|in_list[0,1]',
        ];

        if ($this->request->getPost('password') !== '') {
            $rules['password']          = 'min_length[8]';
            $rules['password_confirm']  = 'matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'is_active' => (int) $this->request->getPost('is_active'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        $password = $this->request->getPost('password');
        if ($password !== '') {
            $data['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
        }

        if (! $this->userModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', $this->userModel->errors()
                ? implode('<br>', $this->userModel->errors())
                : 'Failed to update user.');
        }

        return redirect()->to("/admin/users/{$id}")->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $currentUser = $this->currentUser();
        if ($currentUser && (int) $currentUser->id === (int) $id) {
            return redirect()->to('/admin/users')->with('error', 'You cannot delete your own account.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $newStatus = $user->is_active ? 0 : 1;

        $this->userModel->update($id, [
            'is_active'  => $newStatus,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $label = $newStatus ? 'activated' : 'deactivated';

        return redirect()->to("/admin/users/{$id}")->with('success', "User {$label} successfully.");
    }
}

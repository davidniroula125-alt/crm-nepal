<?php

namespace App\Controllers\Admin;

class Auth extends \App\Controllers\BaseController
{
    public function login()
    {
        return "Auth loaded OK";
    }

    public function attemptLogin()
    {
        return "attemptLogin OK";
    }

    public function logout()
    {
        return redirect()->to('/admin/login');
    }

    public function forgotPassword()
    {
        return "forgotPassword OK";
    }

    public function sendResetLink()
    {
        return "sendResetLink OK";
    }

    public function resetPassword()
    {
        return "resetPassword OK";
    }

    public function updatePassword()
    {
        return "updatePassword OK";
    }
}

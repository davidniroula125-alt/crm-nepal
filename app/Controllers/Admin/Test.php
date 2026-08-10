<?php

namespace App\Controllers\Admin;

class Test extends BaseController
{
    public function index()
    {
        return $this->response->setBody("Admin BaseController OK\nRole: " . (session()->get('user_role') ?? 'none'))->setHeader('Content-Type', 'text/plain');
    }
}

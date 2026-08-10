<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    protected function currentUser(): ?object
    {
        $userId = session()->get('user_id');
        if (! $userId) {
            return null;
        }
        return (object) [
            'id'    => $userId,
            'name'  => session()->get('user_name'),
            'email' => session()->get('user_email'),
            'role'  => session()->get('user_role'),
        ];
    }

    protected function isAdmin(): bool
    {
        return session()->get('user_role') === 'admin';
    }

    protected function isEditor(): bool
    {
        return session()->get('user_role') === 'editor';
    }

    protected function isSupport(): bool
    {
        return session()->get('user_role') === 'support';
    }

    protected function requireAdmin(): void
    {
        if (! $this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
    }

    protected function requireAdminOrEditor(): void
    {
        if (! $this->isAdmin() && ! $this->isEditor()) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
    }
}

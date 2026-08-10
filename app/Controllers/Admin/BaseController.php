<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController as PublicBase;

abstract class BaseController extends PublicBase
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        try {
            parent::initController($request, $response, $logger);
        } catch (\Throwable $e) {
            $response->setStatusCode(500);
            $response->setBody('BaseController initController error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            $response->setHeader('Content-Type', 'text/plain');
            throw $e;
        }
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

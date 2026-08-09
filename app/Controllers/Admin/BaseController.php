<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController as AppBaseController;

/**
 * Base controller for all admin panel controllers.
 * Provides common helpers, session utilities, and shared data.
 */
abstract class BaseController extends AppBaseController
{
    /**
     * Get the currently logged-in admin user from session.
     */
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

    /**
     * Check if the current user is an admin.
     */
    protected function isAdmin(): bool
    {
        return session()->get('user_role') === 'admin';
    }

    /**
     * Check if the current user is a sales representative.
     */
    protected function isSales(): bool
    {
        return session()->get('user_role') === 'sales';
    }

    /**
     * Check if the current user is a support agent.
     */
    protected function isSupport(): bool
    {
        return session()->get('user_role') === 'support';
    }

    /**
     * Require the current user to be an admin. Redirect otherwise.
     */
    protected function requireAdmin(): void
    {
        if (! $this->isAdmin()) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
    }

    /**
     * Require the current user to be admin or sales. Redirect otherwise.
     */
    protected function requireSalesOrAdmin(): void
    {
        if (! $this->isAdmin() && ! $this->isSales()) {
            return redirect()->back()->with('error', 'You do not have permission to access this page.');
        }
    }
}

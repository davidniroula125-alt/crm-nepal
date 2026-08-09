<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    /**
     * Check that the user is logged in before accessing admin routes.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('user_id')) {
            if ($request->isAJAX()) {
                $response = service('response');
                $response->setStatusCode(401);

                return $response->setJSON([
                    'success' => false,
                    'message' => 'Unauthenticated. Please log in.',
                ]);
            }

            return redirect()->to('/admin/login')
                ->with('error', 'Please log in to access the admin panel.');
        }
    }

    /**
     * After — nothing to do here.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed.
    }
}

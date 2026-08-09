<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (!$session->get('user_id')) {
            $uri = $request->getUri()->getPath();

            // Allow public paths
            $publicPaths = ['', '/', '/login', '/signup', '/logout'];
            if (in_array($uri, $publicPaths) || strpos($uri, 'assets') !== false) {
                return;
            }

            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Shared controller for all public-site controllers (Home, Pages, Blog).
 * Admin controllers get their own BaseController under App\Controllers\Admin
 * once Part 2 is built.
 */
abstract class BaseController extends Controller
{
    protected $helpers = ['url', 'form', 'text'];

    /**
     * @var RequestInterface|CLIRequest|IncomingRequest
     */
    protected $request;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Site-wide data available to every public view (nav, footer, theme).
     * Real content (testimonials, FAQs, blog categories) will be pulled
     * from the CMS models once the admin/content layer is built.
     */
    protected function siteData(array $extra = []): array
    {
        return array_merge([
            'siteName'   => 'CRM Software Nepal',
            'currentUrl' => current_url(),
        ], $extra);
    }
}

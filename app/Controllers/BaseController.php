<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $helpers = ['url', 'form', 'text'];

    protected $request;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Site-wide data available to every public view.
     * Loads site settings from database.
     */
    protected function siteData(array $extra = []): array
    {
        $siteModel = model(\App\Models\SiteContentModel::class);
        $settings = $siteModel->getPageContent('settings');

        return array_merge([
            'siteName'   => $settings['general']['site_name'] ?? 'CRM Software Nepal',
            'siteTagline'=> $settings['general']['site_tagline'] ?? '',
            'siteEmail'  => $settings['general']['site_email'] ?? 'info@crmsoftwarenepal.com',
            'sitePhone'  => $settings['general']['site_phone'] ?? '',
            'siteAddress'=> $settings['general']['site_address'] ?? 'Kathmandu, Nepal',
            'footerDesc' => $settings['footer']['company_description'] ?? '',
            'copyright'  => $settings['footer']['copyright'] ?? 'CRM Software Nepal. All rights reserved.',
            'currentUrl' => current_url(),
        ], $extra);
    }
}

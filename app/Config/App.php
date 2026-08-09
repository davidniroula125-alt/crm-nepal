<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    public string $baseURL = 'http://localhost';
    public string $indexPage = '';
    public string $uriProtocol = 'REQUEST_URI';
    public string $defaultLocale = 'en';
    public string $supportedLocales = ['en', 'ne'];
    public string $timezone = 'Asia/Kathmandu';
    public bool $forceGlobalSecureRequests = false;

    public function __construct()
    {
        parent::__construct();

        $envUrl = getenv('CI_BASEURL');
        if ($envUrl !== false && $envUrl !== '') {
            $this->baseURL = rtrim($envUrl, '/') . '/';
        } else {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $this->baseURL = $protocol . '://' . $host . '/';
        }
    }
}

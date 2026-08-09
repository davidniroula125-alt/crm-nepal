<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    public string $baseURL = '';
    public string $indexPage = '';
    public string $uriProtocol = 'REQUEST_URI';
    public string $defaultLocale = 'en';
    public string $supportedLocales = ['en', 'ne'];
    public string $timezone = 'Asia/Kathmandu';
    public bool $forceGlobalSecureRequests = false;
    public array $cookiePrefix = '';
    public string $cookieDomain = '';
    public string $cookiePath = '/';
    public bool $cookieSecure = false;
    public bool $cookieHTTPOnly = false;
    public bool $cookieSameSite = 'Lax';
    public int $cookieLifetime = 28800;

    public function __construct()
    {
        parent::__construct();
        $this->baseURL = getenv('CI_BASEURL') ?: ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    }
}

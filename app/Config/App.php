<?php

namespace Config;

class App
{
    public string $baseURL = '';
    public string $indexPage = '';
    public string $uriProtocol = 'REQUEST_URI';
    public string $adminEmail = 'admin@example.com';
    public bool $showPHPInfo = false;
    public array $sensitiveHTTPHeaders = [];
    public string $sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler';
    public ?string $sessionSavePath = null;
    public bool $sessionMatchIP = false;
    public int $sessionToUpdate = 0;
    public bool $sessionRegenerateDestroy = false;
    public string $cookiePrefix = '';
    public string $cookieDomain = '';
    public string $cookiePath = '/';
    public bool $cookieSecure = false;
    public bool $cookieHTTPOnly = false;
    public string $cookieSameSite = 'Lax';
    public int $cookieExpires = 0;
    public bool $csrfProtection = false;
    public bool $csrfRedirect = false;
    public string $csrfTokenName = 'csrf_token';
    public string $csrfHeaderName = 'X-CSRF-TOKEN';
    public string $csrfCookieName = 'csrf_cookie';
    public int $csrfExpire = 7200;
    public bool $csrfRegenerate = true;
    public array $csrfExcludeURIs = [];
    public bool $forceGlobalSecureRequests = false;
    public bool $CSPEnabled = false;
}

<?php

namespace Config;

class Session
{
    public string $driver = 'CodeIgniter\Session\Handlers\FileHandler';
    public string $sessionSavePath = null;
    public string $matchIP = false;
    public int    $timeToUpdate = 0;
    public bool   $regenerateDestroy = false;
    public string $cookieName = 'ci_session';
    public int    $cookieExpire = 7200;
    public string $cookiePath = '/';
    public string $cookieDomain = '';
    public string $cookieSecure = false;
    public string $cookieHTTPOnly = false;
    public string $cookieSameSite = 'Lax';
}

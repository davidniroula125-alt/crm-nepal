<?php

namespace Config;

class CodeIgniter
{
    public string $CIEnvironment = 'production';
    public string $baseURL = '';
    public string $indexPage = '';
    public bool $showExceptions = true;
    public bool $sprayIdentifierAttempts = 10;
    public bool $enable_CSRF = false;
    public string $sessionSavePath = null;
    public string $sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler';
}

<?php

namespace Config;

class Autoload
{
    public string $psr4 = [
        'Config'        => APPPATH . 'Config',
        'App'           => APPPATH,
        'CodeIgniter'   => SYSTEMPATH,
        'CodeIgniter\Shield' => APPPATH . 'ThirdParty\Shield',
    ];

    public array $classmap = [
        'CIValidator' => SYSTEMPATH . 'Language/en/CIValidator.php',
    ];

    public string $files = [];

    public string $discoverEvents = false;

    public array $modules = [];
}

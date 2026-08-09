<?php

namespace Config;

class Autoload
{
    public array $psr4 = [
        'Config'    => APPPATH . 'Config',
        'App'       => APPPATH,
    ];

    public array $classmap = [];

    public array $files = [];

    public bool $discoverEvents = false;

    public array $modules = [];
}

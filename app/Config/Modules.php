<?php

namespace Config;

use CodeIgniter\Modules\Modules as BaseModules;

class Modules extends BaseModules
{
    public bool $enabled = true;
    public bool $discoverInComposer = true;
    public array $composerPackages = [];
    public array $aliases = [
        'events',
        'filters',
        'registrars',
        'routes',
        'services',
    ];
}

<?php

namespace Config;

class Toolbar
{
    public array $collectors = [
        'CodeIgniter\DebugToolbar\Collectors\Time',
        'CodeIgniter\DebugToolbar\Collectors\Database',
        'CodeIgniter\DebugToolbar\Collectors\Logs',
        'CodeIgniter\DebugToolbar\Collectors\Variables',
        'CodeIgniter\DebugToolbar\Collectors\HttpHeaders',
    ];

    public array $watchers = [];

    public array $collectableRoutes = [];

    public bool $enableRouteDiscovery = true;

    public string $url = '__open_bar';
}

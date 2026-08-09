<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;

class Filters extends BaseFilters
{
    /**
     * Custom filter aliases.
     */
    public array $aliases = [
        'csrf'          => \CodeIgniter\Filters\Csrf::class,
        'honeypot'      => \CodeIgniter\Filters\Honeypot::class,
        'invalidchars'  => \CodeIgniter\Filters\InvalidChars::class,
        'secureheaders' => \CodeIgniter\Filters\SecureHeaders::class,
        'adminAuth'     => \App\Filters\AdminAuth::class,
    ];
}

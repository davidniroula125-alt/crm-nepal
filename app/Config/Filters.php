<?php namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;

class Filters extends BaseFilters
{
    public array $aliases = [
        'auth' => \App\Filters\AuthFilter::class,
    ];

    public array $globals = [
        'before' => [],
        'after'  => [],
    ];

    public array $methods = [];

    public array $filters = [
        'auth' => [
            'before' => [
                'dashboard',
                'contacts/*',
                'pipeline/*',
                'invoices/*',
                'reports',
                'settings/*',
                'content/*',
                'inquiries/*',
                'complaints/*',
                'users/*',
            ],
        ],
    ];
}

<?php namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use App\Filters\AuthFilter;

class Filters extends BaseFilters
{
    public array $aliases = [
        'auth' => AuthFilter::class,
    ];

    public array $globals = [
        'before' => [
            'auth' => [
                'except' => [
                    '/',
                    '/login',
                    '/signup',
                    '/logout',
                    '/assets/*',
                    '/api/*',
                ],
            ],
        ],
        'after'  => [],
    ];

    public array $methods = [];

    public array $filters = [];
}

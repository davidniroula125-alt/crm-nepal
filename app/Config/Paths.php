<?php

namespace Config;

/**
 * Standard CI4 Paths config. Populated with default values —
 * matches a stock CI4 install once `composer install` has run.
 */
class Paths
{
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';
    public string $appDirectory = __DIR__ . '/..';
    public string $writableDirectory = __DIR__ . '/../../writable';
    public string $testsDirectory = __DIR__ . '/../../tests';
    public string $viewDirectory = __DIR__ . '/../Views';
}

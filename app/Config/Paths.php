<?php namespace Config;

class Paths
{
    /**
     * Points to the framework's system directory
     */
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * Points to the application directory
     */
    public string $appDirectory = __DIR__ . '/..';

    /**
     * Points to the writable directory
     */
    public string $writableDirectory = __DIR__ . '/../../writable';

    /**
     * Points to the tests directory
     */
    public string $testsDirectory = __DIR__ . '/../../tests';

    /**
     * Points to the view directory
     */
    public string $viewDirectory = __DIR__ . '/../Views';

    /**
     * Points to the environment directory
     */
    public string $envDirectory = __DIR__ . '/../../';
}

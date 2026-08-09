<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Session extends BaseConfig
{
    public string $driver = 'CodeIgniter\Session\Drivers\File';
    public string $savePath = '';
    public string $matchIP = false;
    public int $timeToUpdate = 0;
    public int $regenerateDestroy = false;
    public int $expiration = 28800;
    public int $expireOnClose = false;
    public bool $encrypt = false;
    public bool $matchUserAgent = true;
    public string $probability = 100;
    public string $tableName = 'ci_sessions';

    public function __construct()
    {
        parent::__construct();
        $this->savePath = WRITEPATH . 'session';
    }
}

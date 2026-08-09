<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cache extends BaseConfig
{
    public string $handler = 'file';
    public string $backupHandler = '';
    public int $ttl = 60;
    public string $filesPath = WRITEPATH . 'cache';
    public bool $filePermissions = false;
    public array $memcache = [];
    public array $redis = [];
}

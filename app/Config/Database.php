<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Database extends BaseConfig
{
    public string $defaultGroup = 'default';
    public array $queryDriver = ['MySQLi' => \CodeIgniter\Database\MySQLi\Driver::class];
    public array $groups = [];

    public function __construct()
    {
        parent::__construct();
        $this->groups['default'] = [
            'DSN'      => '',
            'hostname' => getenv('DB_HOST') ?: 'localhost',
            'username' => getenv('DB_USER') ?: 'root',
            'password' => getenv('DB_PASS') ?: '',
            'database' => getenv('DB_NAME') ?: 'crm_nepal',
            'DBDriver' => 'MySQLi',
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8mb4',
            'DBCollat' => 'utf8mb4_unicode_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => getenv('DB_PORT') ?: '3306',
        ];
    }
}

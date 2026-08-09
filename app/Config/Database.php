<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Database extends BaseConfig
{
    public string $defaultGroup = 'default';
    public array $queryDriver = [
        'Postgre' => \CodeIgniter\Database\Postgre\Driver::class,
    ];
    public array $groups = [];

    public function __construct()
    {
        parent::__construct();
        $this->groups['default'] = [
            'DSN'      => '',
            'hostname' => getenv('DB_HOST') ?: 'localhost',
            'username' => getenv('DB_USER') ?: 'postgres',
            'password' => getenv('DB_PASS') ?: '',
            'database' => getenv('DB_NAME') ?: 'crm_nepal',
            'DBDriver' => 'Postgre',
            'DBPrefix' => '',
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8',
            'DBCollat' => '',
            'swapPre'  => '',
            'schema'   => 'public',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => getenv('DB_PORT') ?: '5432',
        ];
    }
}

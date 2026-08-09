<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
    public bool $enabled = false;
    public array $allowedOrigins = [];
    public array $allowedMethods = [];
    public array $allowedHeaders = [];
    public array $exposedHeaders = [];
    public int $maxAge = 0;
    public bool $credentials = false;
}

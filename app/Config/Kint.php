<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Kint extends BaseConfig
{
    public bool $enabled = true;
    public bool $cliColors = true;
    public bool $calledFromCli = false;
    public bool $useGlobalStack = false;
    public bool $useColors = true;
    public int $maxDepth = 6;
    public bool $displayCalledFrom = true;
    public bool $sort = false;
    public bool $forceArrayKeys = false;
    public bool $expandedByDefault = true;
    public bool $pluginAutoDiscover = true;
    public bool $pluginKintParser = true;
    public bool $pluginSlevomat = true;
    public array $pluginPaths = [];
}

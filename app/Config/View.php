<?php

namespace Config;

use CodeIgniter\Config\View as BaseView;
use CodeIgniter\View\ViewDecoratorInterface;

class View extends BaseView
{
    public bool $saveData = true;
    public array $filters = [];
    public array $plugins = [];
    public array $decorators = [];
    public string $appOverridesFolder = 'overrides';
}

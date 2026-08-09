<?php

namespace Config;

class View
{
    public string $parserClass = 'CodeIgniter\View\Parser';
    public string $parserPluginPath = '';
    public array  $filters = [];
    public string $decorator = '';
    public string $space = '';
    public bool   $saveData = false;
    public string $cascadeDelimiter = '|';
    public array  $sectionDelimiters = ['section', 'endSection'];
    public array  $templateDelimiters = ['template', 'endTemplate'];
}

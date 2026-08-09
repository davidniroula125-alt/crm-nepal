<?php

namespace Config;

class Security
{
    public string $tokenName  = 'csrf_token';
    public string $headerName = 'X-CSRF-TOKEN';
    public string $cookieName = 'csrf_cookie';
    public int    $expire     = 7200;
    public bool   $regenerate = true;
    public bool   $redirect   = false;
    public string $samesite   = 'Lax';
    public array  $excludeURIs = [];
    public bool   $redirectAjax = false;
    public string $tokenRandomize = '';
}

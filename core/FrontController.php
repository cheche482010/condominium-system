<?php

namespace Core;

class FrontController 
{
    public function __construct()
    {
        $url = $_GET['url'] ?? '';
        $url = strpos($url, 'api/') === 0 ? substr($url, 4) : $url;
        $router = new Router();
        $router->route($url);
    }
}

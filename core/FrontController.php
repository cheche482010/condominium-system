<?php

namespace Core;

class FrontController 
{
    public function __construct()
    {
        $url = $_GET['url'] ?? '';
        $router = new Router();
        $router->route($url);
    }
}

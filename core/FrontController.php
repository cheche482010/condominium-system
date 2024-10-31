<?php

namespace Core;

class FrontController 
{
    public function __construct()
    {
        $url = $_GET['url'] ?? '';
        $url = strpos($url, 'api/') === 0 ? substr($url, 4) : $url;

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, API_KEY");
        
        $router = new Router();
        $router->route($url);
    }
}

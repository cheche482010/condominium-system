<?php

namespace App\Controllers;

class ErrorController
{
    public function __call($name, $arguments)
    {
        if (strpos($name, '_') === 0) {
            $statusCode = intval(substr($name, 1));
            if ($statusCode >= 400 && $statusCode < 600) {
                http_response_code($statusCode);
                include_once __DIR__ . "/../Views/error/$statusCode.php";
            }
        }
    }
}

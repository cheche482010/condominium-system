<?php

namespace App\Controllers;

class ErrorController
{
    public $URL;

    function __construct()
    {
        $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
        $domain = $_SERVER['HTTP_HOST'];
        $root = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']) . '/';
        $this->URL = $protocol . $domain . $root;
    }
    
    private function handleErrorCode($statusCode)
    {
        try {
            $filePath = __DIR__ . "/../Views/error/$statusCode/$statusCode.php";
            http_response_code($statusCode);
            require $filePath;
        } catch (\Exception $e) {
            http_response_code(500);
            throw new \Exception("Error: Archivo de error no encontrado: $filePath" . $e->getMessage());
        }
    }

    public function __call($name, $arguments)
    {
        if (strpos($name, '_') === 0) {
            $statusCode = intval(substr($name, 1));
            if ($statusCode >= 400 && $statusCode < 600) {
                $this->handleErrorCode($statusCode);
            }
        }
    }

}

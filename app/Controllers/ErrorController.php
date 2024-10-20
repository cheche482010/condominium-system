<?php

namespace App\Controllers;

class ErrorController
{
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

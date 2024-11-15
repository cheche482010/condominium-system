<?php

namespace App\Controllers;

use Core\Config;

class BaseController
{
    use \Core\Traits\ErrorMessage;
    protected $model;
    protected $validator;
    
    protected $components = [];
    protected $expectedApiKey;
    protected $secretToken; 
    
    public $config;

    public function __construct()
    {
        $controllerName = substr(get_class($this), strrpos(get_class($this), '\\') + 1);
        $modelName = "App\Models\\" . str_replace("Controller", "Model", $controllerName);
        $this->model = new $modelName();
        $this->config = new Config();
    }

    public function isGetRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            throw new \Exception("Solo se acepta solicitud GET");
        }
    }

    public function isPostRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new \Exception("Solo se acepta solicitud POST");
        }
    }

    public function isPutRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            throw new \Exception("Solo se acepta solicitud PUT");
        }
    }

    public function isDeleteRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            throw new \Exception("Solo se acepta solicitud DELETE");
        }
    }

    public function response($code, $status, $type, $message, $data = null)
    {
        $response = [
            'code' => $code,
            'status' => $status,
            'type' => $type,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function handleIsUserLoggedIn(): void
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            $this->handle403Error(); 
            exit();
        }
    }

    public function handleAuthorization() {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        
        if ($token !== 'Bearer ' . $this->secretToken) {
            http_response_code(401);
            return false;
        }
        
        return true;
    }

    public function handleApiKey(): bool {
        $apiKey = $_SERVER['HTTP_API_KEY'] ?? null;
        
        if (!$apiKey || $apiKey !== $this->expectedApiKey) {
            http_response_code(403);
            return false;
        }
        
        return true;
    }

    private function checkRateLimit()
    {
        $limit = 100; 
        $timestamp = time();
        $key = md5($_SERVER['REMOTE_ADDR'] . $timestamp);

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = 0;
        } else {
            $_SESSION[$key]++;
        }

        if ($_SESSION[$key] > $limit) {
            $this->response(self::HTTP_TOO_MANY_REQUESTS, false, 'error', 'Ha excedido el límite de solicitudes permitidas.');
            return false;
        }

        $_SESSION[$key]--;
        unset($_SESSION[$key]);
        return true;
    }

    public function validateShortcode()
    {
        $shortcode = $_SERVER['HTTP_SHORTCODE'] ?? null;

        if (!$shortcode) {
            http_response_code(self::HTTP_BAD_REQUEST);
            $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'Shortcode is required.');
            return false; 
        }

        return true; 
    }

    public function verifySecurityToken($token)
    {
        if ($token !== $_SESSION['token']) {
            $this->response(self::HTTP_UNAUTHORIZED, 'Unauthorized', 'error', 'No autorizado');
            return false;
        }
        return true;
    }

    protected function handlePDOExption($e, $method) {
        $errorMessage = $this->formatErrorMessage($e, $method);
        $errorMessageJson = json_encode($errorMessage, JSON_PRETTY_PRINT);
        $errorLogEntry = "====================================\n{$errorMessageJson}\n";
        error_log($errorLogEntry , 3, 'core/Logs/error.log');  

        return $errorMessage;
    }
}

<?php

namespace App\Controllers;

use Core\BaseModel;
use Core\Config;
use App\Controllers\ErrorController;

class BaseController
{
    protected $model;
    protected $validator;
    protected $assets;
    protected $assetsView;
    protected $components = [];
    protected $session;
    protected $error;
    protected $expectedApiKey;
    protected $secretToken; 
    
    public $config;

    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_CONFLICT_STATUS_CODE = 409;
    const HTTP_TOO_MANY_REQUESTS = 429;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    const MSG_SUCCESS = 'Operación realizada con éxito';
    const MSG_ERROR = 'Ocurrió un error durante la operación';
    
    public function __construct()
    {
        $controllerName = substr(get_class($this), strrpos(get_class($this), '\\') + 1);
        $modelName = "App\Models\\" . str_replace("Controller", "Model", $controllerName);
        $validator = "App\Controllers\Validation\\Validator";
        $this->model = new $modelName();
        $this->validator = new $validator();
        $this->assets = $this->Assets();
        $this->assetsView = $this->assetsView();
        $this->config = new Config();
        $this->session = $_SESSION;
        $this->error = new ErrorController();
    }

    protected function createComponent($className, $data = [])
    {
        if (!class_exists($className)) {
            throw new \Exception("Class $className not found.");
        }

        $component = new $className($data);
        $this->components[] = $component;

        return $component;
    }

    public function __call($method, $args)
    {
        $componentName = ucfirst($method) . 'Component';
        $componentClass = "App\\Components\\$componentName";

        if (class_exists($componentClass)) {
            return $this->createComponent($componentClass, ...$args);
        }
        throw new \Exception("Method $method not found.");
    }

    public function getFullUrl()
    {
        $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
        $domain = $_SERVER['HTTP_HOST'];
        $root = str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']) . '/';
        return $protocol . $domain . $root;
    }

    public function Assets()
    {
        $url = $this->getFullUrl();
        return $url . "public/assets/";
    }

    public function assetsView()
    {
        $url = $this->getFullUrl();
        return $url . 'app/Views/';
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
        echo json_encode($response);
    }

    public function handleIsUserLoggedIn(): void
    {
        if (!isset($this->session['user']) || empty($this->session['user'])) {
            $this->error->_403_(); 
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

    protected function secureSession()
    {
        session_start();
        session_set_cookie_params(3600); // Expira en una hora
        session_regenerate_id(true);

        $this->session['token'] = bin2hex(random_bytes(32));
        setcookie('PHPSESSID', session_id(), time() + 3600, '/', $_SERVER['HTTP_HOST'], false, true);
        setcookie('security_token', $this->session['token'], time() + 3600, '/', $_SERVER['HTTP_HOST'], false, true);
    }

    public function verifySecurityToken($token)
    {
        if ($token !== $this->session['token']) {
            $this->response(self::HTTP_UNAUTHORIZED, 'Unauthorized', 'error', 'No autorizado');
            return false;
        }
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

}

<?php

namespace App\Controllers;

use Core\BaseModel;

class BaseController
{
    protected $model;
    protected $validator;
    protected $assets;
    protected $components = [];

    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    const MSG_SUCCESS = 'Operación realizada con éxito';
    const MSG_ERROR = 'Ocurrió un error durante la operación';
    
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $controllerName = substr(get_class($this), strrpos(get_class($this), '\\') + 1);
        $modelName = "App\Models\\" . str_replace("Controller", "Model", $controllerName);
        $validator = "App\Controllers\Validation\\Validator";
        $this->model = new $modelName();
        $this->validator = new $validator();
        $this->assets = $this->Assets();
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

    public function Assets()
    {
        $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
        $domain   = $_SERVER['HTTP_HOST'];
        $root     = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']) . "/";
        return $protocol . $domain . $root . "assets/";
        unset($protocol, $domain, $root);
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

        return json_encode($response);
    }
}

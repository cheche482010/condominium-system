<?php

namespace Core;

class Router
{
    use \Core\Traits\ErrorMessage;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function route($url)
    {
        $url = strtolower($url);

        if (empty($url) || $url === 'api') {
            return $this->handleApiRoute();
        }

        $parts = explode('/', $url);
        
        if (count($parts) < 2) {
            return $this->handle404Error("No se especificó suficiente información en la URL.");
        }

        $controllerName = ucfirst($parts[0])."Controller";
        $actionName = isset($parts[1]) ? $parts[1] : '';
        $param = isset($parts[2]) ?  $parts[2] : '';

        $controllerClass = "App\Controllers\\$controllerName";
        
        if (!class_exists($controllerClass)) {
            return $this->handle404Error("El controlador $controllerName no existe.");
        }

        $controller = new $controllerClass();
        
        if (!$actionName || !method_exists($controller, $actionName)) {
            return $this->handle404Error("La acción $actionName no existe en el controlador $controllerName.");
        }

        try {
            if ($actionName !== '') {
                if ($param !== '') {
                    call_user_func_array([$controller, $actionName], [$param]);
                } else {
                    $controller->$actionName();
                }
            }
        } catch (\Exception $e) {
            return $this->handleInternalServerError($e);
        }
        
        return;
    }

    private function handleApiRoute()
    {
        $routerController = new \App\Controllers\RouterController();
        $routerController->api();
    }
}

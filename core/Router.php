<?php

namespace Core;

use App\Controllers\ErrorController;

class Router
{
    private $routes = [];
    private $error;
    private $session;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->error = new ErrorController();

        $this->routes = [
            'swagger'        => 'RouterController@swgger',
            'home'           => 'RouterController@renderView|home',
            'contacto'       => 'RouterController@renderView|contacto',
            'login'          => 'UserController@renderView|login',
            'register'       => 'UserController@renderView|register',
            'user/list'           => 'UserController@renderView|list',
            'user/create'    => 'UserController@create',
            'user/auth'      => 'UserController@auth',
            'user/getAll'    => 'UserController@getAll',
            'user/get/:id'   => 'UserController@get',
            'condominio/list' => 'CondominioController@renderView|list',
            'condominio/register' => 'CondominioController@renderView|register',
        ];

        $this->getSession();
    }

    public function route($url)
    {
        $url = $this->removeQueryString($url);
        $url = strtolower($url);
        $url = $this->isAuthenticated($url);
        
        foreach ($this->routes as $route => $action) {
            $route = strtolower($route);
            $pattern = preg_replace('/(:\w+)/', '(\w+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $url, $matches)) {
                $parts = explode('@', $action);
                $controllerName = $parts[0];
                $actionName = $parts[1];

                $controllerClass = "App\Controllers\\$controllerName";
                $controller = new $controllerClass();

                if (strpos($actionName, '|') !== false) {
                    $actionDetails = explode('|', $actionName);
                    $methodName = $actionDetails[0];
                    $viewName = $actionDetails[1];
                    $controller->$methodName($viewName);
                } else {
                    array_shift($matches);
                    call_user_func_array([$controller, $actionName], $matches);
                }

                return;
            }
        }

        if ($this->isApiRequest()) {
            $this->sendApiNotFoundResponse();
        } else {
            $this->error->_404_();
        }
    }

    private function removeQueryString($url)
    {
        if (($pos = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $pos);
        }
        return $url;
    }

    private function isAuthenticated($url)
    {
        return (empty($this->session) && empty($url)) ? 'login' : (!empty($this->session) && empty($url) ? 'home' : $url);
    }

    private function getSession()
    {
        $this->session = isset($_SESSION['user']) && isset($_SESSION['user']['sesion_token']) ? $_SESSION['user'] : null;
    }

    private function isApiRequest()
    {
        return strpos($_GET['url'], 'api/') === 0;
    }

    private function sendApiNotFoundResponse()
    {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode([
            'code' => 404,
            'status' => false,
            'type' => 'error',
            'message' => 'API endpoint not found',
            'data' => null
        ]);
        exit();
    }
}

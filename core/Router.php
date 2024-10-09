<?php

namespace Core;

use App\Controllers\ErrorController;

class Router
{
    private $routes = [];
    private $error;

    public function __construct()
    {
        $this->error = new ErrorController();

        $this->routes = [
            'home'           => 'HomeController@index',
            'login'          => 'UserController@renderView|login',
            'users/create'   => 'UserController@create',
            'users/login'    => 'UserController@login',
            'user/getAll'    => 'UserController@getAll',
            'user/get/:id'   => 'UserController@get',
        ];
    }

    public function route($url)
    {
        $url = $this->removeQueryString($url);
        $url = empty($url) ? 'home' : $url;
        
        foreach ($this->routes as $route => $action) {

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

        $this->error->_404_();
    }

    private function removeQueryString($url)
    {
        if (($pos = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $pos);
        }
        return $url;
    }
}

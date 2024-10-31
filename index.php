<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$baseDir = '/www/prueba/';
$route = str_replace($baseDir, '', $uri);

if (empty($route) || $route === '/') {
    $route = 'home/home';
} else {
    $segments = explode('/', $route);
    $lastSegment = end($segments);
    $route .= '/' . $lastSegment;
}

$viewBasePath = __DIR__ . '/frontend/';

$filePath = $viewBasePath . $route . '.php';

if (file_exists($filePath)) {
    require $filePath;
} else {
    echo "404 - Página no encontrada";
}
?>

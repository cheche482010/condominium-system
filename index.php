<?php
define('URL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']) . "/");
define("TITLE", "Condominium System");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$route = str_replace('/www/condominium-system/', '', $uri);

if (empty($route) || $route === '/') {
    $route = 'home';
} else {
    $route = trim($route, '/');
}

$viewBasePath = __DIR__ . '/frontend/';
$segments = explode('/', $route);
$filePath = $viewBasePath . implode('/', $segments) . '/' . end($segments) . '.php';

if (file_exists($filePath)) {
    include $filePath;
} else {
    header("HTTP/1.0 404 No Encontrado");
    http_response_code(404);
    echo "404 - Página no encontrada";
}
?>

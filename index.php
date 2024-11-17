<?php
define('URL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']) . "/");
define("TITLE", "Condominium System");

session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$route = str_replace('/www/condominium-system/', '', $uri);

if (empty($route) || $route === '/') {
    header("Location: " . URL . (hasValidSession() ? "home" : "user/login"));
exit();

} elseif ($route === 'user/login') {
    if (hasValidSession()) {
        header("Location: " . URL . "home");
        exit();
    }
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
    header("Location: " . URL . "error/404");
}

function verifySession() : void {
    if (!isset($_SESSION['user']) || empty($_SESSION['user']) || !isset($_SESSION['user']["sesion_token"]) || empty($_SESSION['user']["sesion_token"])) {
        header("HTTP/1.0 403 Forbidden");
        http_response_code(403);
        header("Location: " . URL . "error/403");
        return;
    }
}

function hasValidSession(): bool {
    return (
        isset($_SESSION['user'])
        && isset($_SESSION['user']['sesion_token'])
        && !empty($_SESSION['user']['sesion_token'])
    );
}

?>

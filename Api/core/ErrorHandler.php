<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_error_handler(function ($errno, $errstr, $errfile, $errline) {

    switch ($errno) {
        case E_ERROR:
        case E_CORE_ERROR:
        case E_COMPILE_ERROR:
        case E_USER_ERROR:
            $message = "Critical Error: {$errstr}";
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $message = "Warning: {$errstr}";
            break;
        case E_PARSE:
            $message = "Syntax Error: {$errstr}";
            break;
        case E_NOTICE:
        case E_USER_NOTICE:
            $message = "Notice: {$errstr}";
            break;
        case E_STRICT:
            $message = "Strict Notice: {$errstr}";
            break;
        case E_RECOVERABLE_ERROR:
            $message = "Recoverable Error: {$errstr}";
            break;
        default:
            $message = "Unknown Error: {$errno}: {$errstr}";
    }

    $response = [
        'code' => $errno,
        'status' => 'error',
        'type' => $errno,
        'message' => $message,
        'data' => [
            'trace' => debug_backtrace(),
        ],
        "timestamp" => date('Y-m-d H:i:s'),
    ];

    $response =  json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $errorLogEntry = "====================================\n{$response}\n";
    error_log($errorLogEntry, 3, __DIR__ . '/../core/Logs/error.log');
    exit($response);
}, E_ALL);

set_exception_handler(function ($exception) {
    $errorMessageJson = json_encode([
        "Type" => get_class($exception),
        "httpMethod" => $_SERVER['REQUEST_METHOD'],
        "code" => $exception->getCode(),
        "line" => $exception->getLine(),
        "message" => $exception->getMessage(),
        "file" => $exception->getFile(),
        'backtrace' => $exception->getTraceAsString(),
        "timestamp" => date('Y-m-d H:i:s'),
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    
    $errorLogEntry = "====================================\n{$errorMessageJson}\n";
    error_log($errorLogEntry , 3, __DIR__ . '/../core/Logs/error.log');

    exit($errorMessageJson);
});

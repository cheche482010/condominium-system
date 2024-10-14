<?php

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $errorMessage = "[ERROR] $errstr in $errfile on line $errline\n"; 

    error_log($errorMessage, 3, __DIR__ . '/../core/Logs/error.log');

    if ($errno === E_ERROR) {
        exit($errstr);
    }
});

set_exception_handler(function ($exception) {
    $errorMessage = "[EXCEPTION] " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine() . "\n"; 

    error_log($errorMessage, 3, __DIR__ . '/../core/Logs/error.log');

    exit($exception->getMessage());
});

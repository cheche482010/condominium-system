<?php

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $errorMessage = "[ERROR] $errstr in $errfile on line $errline\n"; 

    error_log($errorMessage, 3, __DIR__ . '/../core/Logs/error.log');

    if ($errno === E_ERROR) {
        exit($errstr);
    }
});

set_exception_handler(function ($exception) {
    $errorMessageJson = $exception->getMessage();
    $errorLogEntry = "====================================\n{$errorMessageJson}\n";
    error_log($errorLogEntry , 3, __DIR__ . '/../core/Logs/error.log');

    exit($errorMessageJson );
});

<?php

namespace Core\Traits;

trait ErrorMessage
{
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_CONFLICT_STATUS_CODE = 409;
    const HTTP_TOO_MANY_REQUESTS = 429;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    const MSG_SUCCESS = 'Operación realizada con éxito';
    const MSG_ERROR = 'Ocurrió un error durante la operación';

    protected function formatErrorMessage(\Exception $e, string $method): array
    {
        $errorInfo = $e instanceof \PDOException ? $e->errorInfo : null;
        
        return [
            "httpMethod" => $_SERVER['REQUEST_METHOD'],
            "code" => $e->getCode(),
            "sqlState" => $errorInfo[0] ?? null,
            "sqlMessage" => $errorInfo[1] ?? null,
            "line" => $e->getLine(),
            "message" => $e->getMessage(),
            "pdoCode" => $errorInfo[2] ?? null,
            "file" => $e->getFile(),
            "className" => get_class($this),
            "methodName" => $method,
            "timestamp" => date('Y-m-d H:i:s'),
        ];
    }
}
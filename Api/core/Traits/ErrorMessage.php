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
    const MSG_NOT_FOUND = 'Recursos no encontrados';
    const MSG_FORBIDDEN = 'Acceso denegado';

    const OPTION_PRINT = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE;

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
            "trace" => $e->getTrace(),
            "timestamp" => date('Y-m-d H:i:s'),
        ];
    }

    protected function handle404Error(string $message = ''): void
    {
        http_response_code(self::HTTP_NOT_FOUND);
        header($_SERVER['SERVER_PROTOCOL']. " 404 Not Found");
        header('Content-Type: application/json');
        echo json_encode(
            $this->response(self::HTTP_NOT_FOUND, false, 'error', $message ?: self::MSG_NOT_FOUND),
            self::OPTION_PRINT
        );
        exit();
    }

    protected function handle403Error(string $message = ''): void
    {
        http_response_code(self::HTTP_FORBIDDEN);
        header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden");
        header('Content-Type: application/json');
        echo json_encode(
            $this->response(self::HTTP_FORBIDDEN, false, 'error', $message ?: self::MSG_FORBIDDEN),
            self::OPTION_PRINT
        );
        exit();
    }

    private function handleInternalServerError(string $message): void
    {
        http_response_code(self::HTTP_INTERNAL_SERVER_ERROR);
        header($_SERVER['SERVER_PROTOCOL']." Internal Server Error");
        header('Content-Type: application/json');
        echo json_encode(
            $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', $message, $this->formatErrorMessage(new \Exception($message), __METHOD__)),
            self::OPTION_PRINT
        );
        exit();
    }

    public function response($code, $status, $type, $message, $data = null): array
    {
        $response = [
            'code' => $code,
            'status' => $status,
            'type' => $type,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }
        return $response;
    }
}

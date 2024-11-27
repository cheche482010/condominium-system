<?php

namespace Core\Traits;

trait ResponseEndpoint
{
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
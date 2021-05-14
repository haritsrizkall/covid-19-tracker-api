<?php

if (! function_exists('createSuccessResponse')) {
    function createSuccessResponse($code, $status,$message, $data){
        $response = [
            'meta' => [
                'message' => $message,
                'code' => $code,
                'status' => $status,
            ],
            'data' => $data,
        ];
        return $response;
    }
}

if (! function_exists('createFailedResponse')) {
    function createFailedResponse($code, $status,$message, $data){
        $response = [
            'meta' => [
                'message' => $message,
                'code' => $code,
                'status' => $status,
            ],
            'errors' => $data,
        ];
        return $response;
    }
}
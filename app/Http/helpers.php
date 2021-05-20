<?php
use Illuminate\Http\Response;

if (! function_exists('createSuccessResponse')) {
    function createSuccessResponse($code, $status,$message, $data){
        $dataResponse = [
            'meta' => [
                'message' => $message,
                'code' => $code,
                'status' => $status,
            ],
            'data' => $data,
        ];
        $response = new Response($dataResponse,200);
        return $response;
    }
}

if (! function_exists('createFailedResponse')) {
    function createFailedResponse($code, $status,$message, $data){
        $dataResponse = [
            'meta' => [
                'message' => $message,
                'code' => $code,
                'status' => $status,
            ],
            'errors' => $data,
        ];
        $response = new Response($dataResponse,400);
        return $response;
    }
}

if (! function_exists('unauthorizedResponse')) {
    function unauthorizedResponse(){
        $response = [
            'meta' => [
                'message' => 'Unauthorized',
                'code' => 401,
                'status' =>'error',
            ],
            'errors' => 'Unauthorized',
        ];
        return $response;
    }
}
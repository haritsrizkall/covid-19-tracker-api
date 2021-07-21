<?php

use \Firebase\JWT\JWT;


if (! function_exists('generateToken')) {
    function generateToken($userId, $levelId = null){
        $key = "h4r1ts_r1zk4l";
        $payload = array(
            "user_id" => $userId,
            "level_id" => $levelId    
        );
    
        $jwt = JWT::encode($payload, $key);
        return $jwt;
    
    }
}

if (! function_exists('validateToken')) {
    function validateToken($token){
        $key = "h4r1ts_r1zk4l";

        $decoded = JWT::decode($token, $key, array('HS256'));
        return $decoded;
    
    }
}


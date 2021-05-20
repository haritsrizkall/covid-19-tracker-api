<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');
        $authorized = str_contains($header, 'Bearer');
        if (!$authorized) {
            # code...
            $response = unauthorizedResponse();
            return response($response, 401);
        }
        $headerArr = explode(" ", $header);
        $token = $headerArr[1];
        $decodedToken = validateToken($token);
        $request->session()->put('user_info', $decodedToken);
        return $next($request);
    }
}

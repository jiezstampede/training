<?php

namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\Auth;

class authJWT
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate(); 
            //put user in session for logging
            Auth::attempt(['email' => $user->email, 'password' => $user->password, 'status' => 'active']);
        } catch (Exception $e) {
            $response['message'] = 'Error was encountered.';
            $status = 400;
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $response['message'] = 'Token is Invalid';
                $status = 401;
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $response['message'] = 'Token is Expired';
                $status = 401;
            }
            return response($response, $status);
        }
        return $next($request);
    }
}
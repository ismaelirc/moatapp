<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

class JwtMiddleware extends BaseMiddleware
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
        $type = 'submit';
        
        if($request->ajax()){  
            $type = 'ajax';
        }

        try {
            
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                $this->handle_return(['status' => 'User not found'],$type);
            }
            
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                
                $this->handle_return(['status' => 'Token is Invalid'],$type);
                
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                
                $this->handle_return(['status' => 'Token is Expired'],$type);
                
            }else if($e instanceof \Tymon\JWTAuth\Exceptions\JWTException){
               
                $this->handle_return(['status' => 'The token could not be parsed from the request'],$type);

            }else{
                
                $this->handle_return(['status' => 'Authorization Token not found'],$type);
                
            }
        }
        return $next($request);
    }

    private function handle_return($msg, $type_return){

        if($type == 'ajax'){
            return response()->json($msg);
        }            
        
        return redirect()->route('login');
    
    }
}

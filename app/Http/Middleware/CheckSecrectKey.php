<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class CheckSecrectKey 
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request ,Closure $next)
    {
        $secrectKey= $request->input('secretKey');
        if($secrectKey!=config('cumstom.secretKey')){
            return response()->json(['error'=>true,'message'=>'SecretKey not found!']);
        }
        return $next($request);
    }
}
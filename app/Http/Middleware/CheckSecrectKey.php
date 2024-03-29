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
        $secrectKey= $request->input('secrectKey');
        if($secrectKey!=config('cumstom.secrectKey')){
            return response()->json('loi secrectkey');
        }
        return $next($request);
    }
}
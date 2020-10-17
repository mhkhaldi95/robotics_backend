<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authorizor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        foreach($guards as $guard){
            if($request->attributes->get("guard") == $guard)
            return $next($request);
        }
        return response()->json(['message' => "Not Authorize"]);
    }
}

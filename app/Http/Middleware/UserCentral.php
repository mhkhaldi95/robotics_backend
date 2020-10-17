<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserCentral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $guards =['admins','owners','fathers','trainers','sellers','organizers','students'];
        foreach($guards as $guard){
            if(Auth::guard($guard)->check()){
                $request->attributes->set("guard",$guard);
                break;
            }
        }
        return $next($request);
    }
}

<?php

namespace Modules\Training\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CouresStudentMiddlerware
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
//        $course = Route::current()->parameter('course');
//        $section = Route::current()->parameter('section');
//        if(Auth::id() == $course-> )
        return $next($request);
    }
}

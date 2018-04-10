<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class AdminLogin
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
        if (!session("employeeInfo"))
        {
            return redirect("admin/login");
        }
        if (Route::currentRouteName()){
            session(["current_tag"=>Route::currentRouteName()]);
        }
        return $next($request);
    }
}

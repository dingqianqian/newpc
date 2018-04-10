<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class Access
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
        if (session("employeeInfo")["signin_name"]!="admin"){
            if(!in_array(Route::currentRouteName(),session("employeeInfo")['accessMiddleware']))
            {
                if ($request->ajax())
                {
                    return response("对不起，您没有相关权限", 403)
                        ->header('Content-Type', 'application/json');
                }
                return back()->with(["msg"=>"对不起，您没有相关权限"]);
            }
        }
        return $next($request);
    }
}

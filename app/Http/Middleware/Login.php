<?php

namespace App\Http\Middleware;

use Closure;

class Login
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
        if (!session("userInfo"))
        {
        	if($request->ajax())
        	{
        		session(["next"=>null]);
        	}else{
        		session(["next"=>$request->url()]);
        	}
            return redirect("login");
        }
        return $next($request);
    }
}

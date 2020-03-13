<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class Admin
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
        if(empty($request->session()->get("admin"))) {
            $request->session()->flush();
            return redirect("admin/login");
        };
        return $next($request);
    }
}

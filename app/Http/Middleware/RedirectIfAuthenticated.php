<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::user()) {
            if (Auth::user()->hasRole('superadmin')) {
                return redirect("superadmin/home");
            } else if (Auth::user()->hasRole("company")) {
                return redirect("company/home");
            } else if (Auth::user()->hasRole("employee")) {
                return redirect("employee/home");
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyGHLAPIAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse | Symfony\Component\HttpFoundation\Response;
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('x-api-key') && $request->header('x-api-key') === env('GHL_API_KEY')) 
            return $next($request);
        
        return response()->json([
            'success' => false,
            'errors' => 'Unauthorized access!'
        ], 401);
    }
}


<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryMiddleware
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
        // Check if the user is authenticated and has the 'delivery' role
        if (Auth::check() && Auth::user()->role === 'delivery') {
            return $next($request);
        }

        // If the user is not authorized, redirect or return an error response
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
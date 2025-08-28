<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
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
        // Check if the user is authenticated and has the 'client' role
        if (Auth::check() && Auth::user()->role === 'client') {
            return $next($request);
        }

        // Redirect to a specific route or return an error response if not authorized
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin or staff role
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403, 'Unauthorized. Admin access required.');
        }

        return $next($request);
    }
}

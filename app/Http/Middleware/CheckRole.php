<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Allow access to no-access page
        if ($request->routeIs('panel.no-access')) {
            return $next($request);
        }

        // Check if user has any role
        if (!Auth::user()->roles()->exists()) {
            // If user has no roles, redirect to a page explaining they need roles
            return redirect()->route('panel.no-access');
        }

        return $next($request);
    }
}
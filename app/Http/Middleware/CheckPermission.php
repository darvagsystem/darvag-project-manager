<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Super admin has access to everything
        if (Auth::user()->hasRole('super-admin')) {
            return $next($request);
        }

        if (!Auth::user()->can($permission)) {
            abort(403, 'شما مجوز دسترسی به این بخش را ندارید.');
        }

        return $next($request);
    }
}
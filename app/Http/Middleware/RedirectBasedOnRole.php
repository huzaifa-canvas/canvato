<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     * Blocks customers from accessing admin routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // If user is a Customer and trying to access admin routes, redirect to frontend
            if ($user->hasRole('Customer') && $request->is('admin*')) {
                return redirect()->route('frontend.profile');
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPendingAccount
{
    /**
     * Handle an incoming request.
     * Redirect users with 'pending' role to the verification waiting page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isPending()) {
            // Allow access to logout and pending page
            if ($request->routeIs('logout') || $request->routeIs('pending')) {
                return $next($request);
            }
            
            return redirect()->route('pending');
        }

        return $next($request);
    }
}

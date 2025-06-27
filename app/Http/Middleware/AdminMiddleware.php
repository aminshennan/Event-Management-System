<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and an admin
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Optionally, redirect non-admin users to a specific page or return an error
        return redirect('/landingpage'); // Redirect to homepage or login page as appropriate
    }
}


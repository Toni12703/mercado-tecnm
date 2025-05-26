<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        abort(403, 'No tienes permiso para acceder al dashboard.');
    }
}
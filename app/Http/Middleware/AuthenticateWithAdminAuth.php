<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateWithAdminAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (! auth()->guard($guard)->user()->can('administrator')) {
            return abort(403, 'Forbidden');
        }

        return $next($request);
    }
}

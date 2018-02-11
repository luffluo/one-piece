<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class AuthenticateWithAdminAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (! auth()->guard($guard)->user()->may('administrator')) {

            if ($request->ajax()) {
                return new JsonResponse('Not Found', 404);
            }

            return abort(404);
        }

        return $next($request);
    }
}

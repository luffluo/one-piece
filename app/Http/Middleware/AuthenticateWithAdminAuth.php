<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class AuthenticateWithAdminAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (! auth()->guard($guard)->user()->can('administrator')) {

            if ($request->ajax()) {
                return new JsonResponse('Unauthorized', 401);
            }

            return abort(401, 'Unauthorized');
        }

        return $next($request);
    }
}

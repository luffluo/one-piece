<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class Authenticate
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (auth()->guard($guard)->guest()) {

            if ($request->ajax()) {
                return new JsonResponse('Unauthorized', 401);
            }

            return redirect()->guest(route('login'));
        }

        return $next($request);
    }
}
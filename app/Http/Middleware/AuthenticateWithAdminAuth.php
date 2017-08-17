<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateWithAdminAuth
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (auth()->guard($guards)->guest()) {
            return redirect()->intended(route('admin.login'));
        }

        return $next($request);
    }
}

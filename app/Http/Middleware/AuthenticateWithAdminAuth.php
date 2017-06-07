<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/6/6
 * Time: 下午6:37
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;


class AuthenticateWithAdminAuth
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (! auth()->guard($guards)->user()->isAdmin()) {
            throw new AuthenticationException('Unauthenticated.', $guards);
        }

        return $next($request);
    }
}

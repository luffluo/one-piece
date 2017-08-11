<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/6/6
 * Time: 下午6:37
 */

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

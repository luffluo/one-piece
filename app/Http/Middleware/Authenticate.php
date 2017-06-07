<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/6/6
 * Time: 下午7:05
 */

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (auth()->guard($guards)->guest()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

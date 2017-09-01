<?php

namespace App\Http\Middleware;

use Closure;

class CheckInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! app('installer')->installed()) {
            return redirect()->route('install');
        }

        return $next($request);
    }
}

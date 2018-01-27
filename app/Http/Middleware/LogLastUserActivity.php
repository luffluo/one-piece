<?php

namespace App\Http\Middleware;

use Closure;

class LogLastUserActivity
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
        if (auth()->check()) {
            // 更新最后活动时间
            auth()->user()->logLastActivity();
        }

        return $next($request);
    }
}

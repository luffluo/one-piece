<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ShareMessageFromSession
{
    /**
     * @var ViewFactory
     */
    protected $view;

    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->view->share('message', $request->session()->get('message'));

        return $next($request);
    }
}

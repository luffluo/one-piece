<?php

namespace App\Listeners;

use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Events\RouteMatched;

class MenuRouteMatched
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(RouteMatched::class, [$this, 'handle']);
    }

    /**
     * Handle the event.
     *
     * @param  RouteMatched $event
     *
     * @return void
     */
    public function handle(RouteMatched $routeMatched)
    {
        if ($routeMatched->request->is('admin*')) {
            $menus = config()->get('admin');
            foreach ($menus as $first_key => $first) {

                if (isset($first['sub'])) {
                    foreach ($first['sub'] as $second_key => $second) {

                        // 防止子类第一次赋值后，第二次再赋值为空
                        if (! isset($menus[$first_key]['active'])) {
                            $menus[$first_key]['active'] = '';
                        }

                        if (request()->routeIs($second['route'])) {
                            $menus[$first_key]['active']                      = 'focus';
                            $menus[$first_key]['sub'][$second_key]['url']     = request()->fullUrl();
                            $menus[$first_key]['sub'][$second_key]['active']  = 'active';
                            $menus[$first_key]['sub'][$second_key]['display'] = true;
                        }
                    }
                } else {

                    $menus[$first_key]['active'] = '';
                    if (request()->routeIs($first['route'])) {
                        $menus[$first_key]['active']  = 'active';
                        $menus[$first_key]['url']     = request()->fullUrl();
                        $menus[$first_key]['display'] = true;
                    }
                }
            }

            config()->set('admin', $menus);
        }
    }
}

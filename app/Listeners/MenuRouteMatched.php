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
     * @param  RouteMatched  $event
     * @return void
     */
    public function handle(RouteMatched $routeMatched)
    {
        if ($routeMatched->request->is('admin*')) {
            $menus = app('config')->get('admin');
            foreach ($menus as $first_key => $first) {

                if (isset($first['sub'])) {
                    foreach ($first['sub'] as $second_key => $second) {

                        // 防止子类第一次赋值 open 后，第二次再赋值为空
                        if (! isset($menus[$first_key]['active'])) {
                            $menus[$first_key]['active'] = '';
                        }

                        if (app('request')->is($second['active'])) {
                            $menus[$first_key]['active']                     = 'open';
                            $menus[$first_key]['sub'][$second_key]['active'] = 'active';
                        }
                    }
                } else {

                    $menus[$first_key]['active'] = '';
                    if (app('request')->is($first['active'])) {
                        $menus[$first_key]['active'] = 'active';
                    }

                }

            }

            app('config')->set('admin', $menus);
        }
    }
}

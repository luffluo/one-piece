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
    public function handle()
    {
        if (app('request')->is('admin*')) {
            $menus = app('config')->get('admin');
            foreach ($menus as $first_key => $first) {
                if (isset($first['sub'])) {
                    foreach ($first['sub'] as $second_key => $second) {

                        if (isset($second['sub'])) {

                            $menus[$first_key]['sub'][$second_key]['active'] = '';

                            foreach ($second['sub'] as $third_key => $third) {

                                $menus[$first_key]['sub'][$second_key]['sub'][$third_key]['active'] = '';
                                if (app('request')->is($third['active'])) {
                                    $menus[$first_key]['sub'][$second_key]['active'] = 'open';
                                    $menus[$first_key]['sub'][$second_key]['sub'][$third_key]['active'] = 'active';
                                }
                            }

                        } else {
                            $menus[$first_key]['sub'][$second_key]['active'] = '';
                            if (app('request')->is($second['active'])) {
                                $menus[$first_key]['sub'][$second_key]['active'] = 'active';
                            }
                        }
                    }
                }
            }

            app('config')->set('admin', $menus);
        }
    }
}

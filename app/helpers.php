<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/2/14
 * Time: 下午9:57
 */

use Illuminate\Support\Str;
use Illuminate\Contracts\View\Factory as ViewFactory;

if (! function_exists('admin_view')) {

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function admin_view($view = null, $data = [], $mergeData = []) {

        $factory = app(ViewFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        if (Str::contains($view, '::')) {
            return $factory->make($view, $data, $mergeData);
        }

        return $factory->make('admin::' . $view, $data, $mergeData);
    }
}

if (! function_exists('option')) {

    function option($key, $default = null, $user_id = 0) {

    }
}

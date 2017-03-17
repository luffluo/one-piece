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
     * @param  string $view
     * @param  array  $data
     * @param  array  $mergeData
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function admin_view($view = null, $data = [], $mergeData = [])
    {

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

    /**
     * Get / set the specified option value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param array|string $key
     * @param mixed        $default
     * @param integer      $user_id
     *
     * @return mixed
     */
    function option($key = null, $default = null, $user_id = 0)
    {

        $option = app('option.repository');

        if (is_null($key)) {
            return $option;
        }

        if (is_array($key)) {

            switch (count($key)) {
                case 2:
                    return $option->set($key[0], $key[1]);

                case 3:
                    return $option->set($key[0], $key[1], $key[2]);

                default:
                    return;
            }
        }

        return $option->get($key, $default, $user_id);
    }
}

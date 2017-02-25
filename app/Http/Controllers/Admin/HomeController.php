<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/2/14
 * Time: 下午9:56
 */

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {
        return admin_view('index');
    }
}

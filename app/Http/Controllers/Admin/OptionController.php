<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        $site_name = '';

        return admin_view('setting.index', compact('site_name'));
    }

    public function store()
    {
        return redirect()->route('admin.options.index');
    }
}

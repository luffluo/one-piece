<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        $site_name = option('site.name');

        return admin_view('option.index', compact('site_name'));
    }

    public function store()
    {
        option(['site.name', request()->input('site_name')]);

        return redirect()->route('admin.options.index');
    }
}

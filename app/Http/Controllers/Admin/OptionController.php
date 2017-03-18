<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        $site_name        = option('site.name');
        $site_description = option('site.description');

        return admin_view('option.index', compact('site_name', 'site_description'));
    }

    public function store()
    {
        option(['site.name', request()->input('site_name')]);
        option(['site.description', request()->input('site_description')]);

        return redirect()->route('admin.options.index');
    }
}

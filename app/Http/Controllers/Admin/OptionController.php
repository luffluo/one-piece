<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        $site_name        = option('site.name');
        $site_icon        = option('site.icon');
        $site_logo        = option('site.logo');
        $site_keywords    = option('site.keywords');
        $site_description = option('site.description');

        return admin_view(
            'option.index',
            compact('site_name', 'site_icon', 'site_logo', 'site_keywords', 'site_description')
        );
    }

    public function store(Request $request)
    {
        if ($request->hasFile('site_icon')) {
            $request->file('site_icon')->move(public_path(), 'favicon.ico');
        }

        if ($request->hasFile('site_logo')) {
            $request->file('site_logo')->move(public_path('upload/admin'), 'logo.png');

            option(['site.logo', 'upload/admin/logo.png']);
        }

        option(['site.name', $request->input('site_name')]);
        option(['site.keywords', $request->input('site_keywords')]);
        option(['site.description', $request->input('site_description')]);

        return redirect()->route('admin.options.index');
    }
}

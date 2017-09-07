<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function showGeneral()
    {
        $site_name        = option('site.name');
        $site_icon        = option('site.icon');
        $site_logo        = option('site.logo');
        $site_keywords    = option('site.keywords');
        $site_description = option('site.description');
        $site_author      = option('site.author');
        $about_me         = option('site.author.about.me');

        return admin_view(
            'option.general',
            compact(
                'site_name',
                'site_icon',
                'site_logo',
                'site_keywords',
                'site_description',
                'site_author',
                'about_me'
            )
        );
    }

    public function handleGeneral(Request $request)
    {
        if ($request->hasFile('site_icon')) {
            $request->file('site_icon')->move(public_path(), 'favicon.ico');
        }

        if ($request->hasFile('site_logo')) {
            $request->file('site_logo')->move(public_path('uploads/admin'), 'logo.png');

            option(['site.logo', 'uploads/admin/logo.png']);
        }

        option(['site.name', $request->input('site_name')]);
        option(['site.keywords', $request->input('site_keywords')]);
        option(['site.description', $request->input('site_description')]);
        option(['site.author', $request->input('site_author')]);
        option(['site.author.about.me', $request->input('site_author_about_me')]);

        return redirect()->route('admin.options.general')->withMessage('设置已经保存');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function showGeneral()
    {
        $title       = option('title');
        $keywords    = option('keywords');
        $description = option('description');

        return admin_view(
            'option.general',
            compact('title', 'keywords', 'description')
        );
    }

    public function handleGeneral(Request $request)
    {
        // if ($request->hasFile('icon')) {
        //     $request->file('icon')->move(public_path(), 'favicon.ico');
        // }
        //
        // if ($request->hasFile('logo')) {
        //     $request->file('logo')->move(public_path('uploads/admin'), 'logo.png');
        //
        //     option(['site.logo', 'uploads/admin/logo.png']);
        // }

        option(['site.name', $request->input('title')]);
        option(['site.keywords', $request->input('keywords')]);
        option(['site.description', $request->input('description')]);

        return redirect()->route('admin.options.general')->withMessage('设置已经保存');
    }
}

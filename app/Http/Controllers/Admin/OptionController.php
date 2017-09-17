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

        option(['title', $request->input('title')]);
        option(['keywords', $request->input('keywords')]);
        option(['description', $request->input('description')]);

        return redirect()->route('admin.options.general')->withMessage('设置已经保存');
    }

    public function showReading()
    {
        $postDateFormat = option('postDateFormat');
        $postsListSize  = option('postsListSize');
        $pageSize       = option('pageSize');

        return admin_view(
            'option.reading',
            compact('postDateFormat', 'postsListSize', 'pageSize')
        );
    }

    public function handleReading()
    {
        option(['postDateFormat', request()->get('postDateFormat')]);
        option(['postsListSize', request()->get('postsListSize')]);
        option(['pageSize', request()->get('pageSize')]);

        return redirect()->route('admin.options.reading')->withMessage('设置已经保存');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

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

    public function handleGeneral()
    {
        option(['title', request()->input('title')]);
        option(['keywords', request()->input('keywords')]);
        option(['description', request()->input('description')]);

        return redirect()->route('admin.options.general')->withMessage('设置已经保存');
    }

    public function showReading()
    {
        $postDateFormat = option('post_date_format');
        $postsListSize  = option('posts_list_size');
        $pageSize       = option('page_size');

        return admin_view(
            'option.reading',
            compact('postDateFormat', 'postsListSize', 'pageSize')
        );
    }

    public function handleReading()
    {
        option(['post_date_format', request()->get('postDateFormat')]);
        option(['posts_list_size', request()->get('postsListSize')]);
        option(['page_size', request()->get('pageSize')]);

        return redirect()->route('admin.options.reading')->withMessage('设置已经保存');
    }
}

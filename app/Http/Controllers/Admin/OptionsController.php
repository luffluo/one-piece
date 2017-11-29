<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OptionsController extends Controller
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
            'options.general',
            compact('title', 'keywords', 'description')
        );
    }

    public function handleGeneral()
    {
        option(['title' => request()->input('title')]);
        option(['keywords' => request()->input('keywords')]);
        option(['description' => request()->input('description')]);

        return redirect()->route('admin.options.general')->withMessage('设置已经保存');
    }

    public function showDiscussion()
    {
        $commentDateFormat = option('comment_date_format');
        $commentsListSize  = option('comments_list_size');
        $commentsPageSize  = option('comments_page_size');
        $commentsShow      = option('comments_show');

        return admin_view(
            'options.discussion',
            compact('commentDateFormat', 'commentsListSize', 'commentsPageSize', 'commentsShow')
        );
    }

    public function handleDiscussion()
    {
        option(['comment_date_format' => request()->input('commentDateFormat')]);
        option(['comments_list_size' => request()->input('commentsListSize')]);
        option(['comments_page_size' => request()->input('commentsPageSize')]);
        option(['comments_show' => request()->input('commentsShow', [])]);

        return redirect()->route('admin.options.discussion')->withMessage('设置已经保存');
    }

    public function showReading()
    {
        $postDateFormat = option('post_date_format');
        $postsListSize  = option('posts_list_size');
        $pageSize       = option('page_size');

        return admin_view(
            'options.reading',
            compact('postDateFormat', 'postsListSize', 'pageSize')
        );
    }

    public function handleReading()
    {
        option(['post_date_format' => request()->get('postDateFormat')]);
        option(['posts_list_size' => request()->get('postsListSize')]);
        option(['page_size' => request()->get('pageSize')]);

        return redirect()->route('admin.options.reading')->withMessage('设置已经保存');
    }
}
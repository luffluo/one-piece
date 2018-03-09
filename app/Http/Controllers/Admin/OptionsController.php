<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function showGeneral()
    {
        $title         = option('title');
        $keywords      = option('keywords');
        $description   = option('description');
        $allowRegister = option('allow_register');

        return admin_view(
            'options.general',
            compact('title', 'keywords', 'description', 'allowRegister')
        );
    }

    public function handleGeneral(Request $request)
    {
        option(['title' => $request->input('title')]);
        option(['keywords' => $request->input('keywords')]);
        option(['description' => $request->input('description')]);
        option(['allow_register' => $request->input('allowRegister')]);

        return redirect()->route('admin.options.general')->withMessage('设置已经保存');
    }

    public function showDiscussion()
    {
        $commentDateFormat    = option('comment_date_format');
        $commentsListSize     = option('comments_list_size');
        $commentsPageSize     = option('comments_page_size');
        $commentsShow         = option('comments_show', []);
        $commentsPost         = option('comments_post', []);
        $commentsPostInterval = option('comments_post_interval', 1);

        return admin_view(
            'options.discussion',
            compact('commentDateFormat', 'commentsListSize', 'commentsPageSize', 'commentsShow', 'commentsPost', 'commentsPostInterval')
        );
    }

    public function handleDiscussion(Request $request)
    {
        option(['comment_date_format' => $request->input('commentDateFormat')]);
        option(['comments_list_size' => $request->input('commentsListSize')]);
        option(['comments_page_size' => $request->input('commentsPageSize')]);

        option(['comments_show' => $request->input('commentsShow', [])]);

        option(['comments_post' => $request->input('commentsPost', [])]);
        option(['comments_post_interval' => intval($request->input('commentsPostInterval'))]);

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

    public function handleReading(Request $request)
    {
        option(['post_date_format' => $request->get('postDateFormat')]);
        option(['posts_list_size' => $request->get('postsListSize')]);
        option(['page_size' => $request->get('pageSize')]);

        return redirect()->route('admin.options.reading')->withMessage('设置已经保存');
    }
}

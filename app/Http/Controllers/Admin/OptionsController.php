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
        $title         = setting('title');
        $keywords      = setting('keywords');
        $description   = setting('description');
        $allowRegister = setting('allow_register');

        return admin_view(
            'options.general',
            compact('title', 'keywords', 'description', 'allowRegister')
        );
    }

    public function handleGeneral(Request $request)
    {
        setting(['title' => $request->input('title')]);
        setting(['keywords' => $request->input('keywords')]);
        setting(['description' => $request->input('description')]);
        setting(['allow_register' => $request->input('allowRegister')]);

        return redirect()->route('admin.options.general')->withMessage('设置已经保存');
    }

    public function showDiscussion()
    {
        $commentDateFormat    = setting('comment_date_format');
        $commentsListSize     = setting('comments_list_size');
        $commentsPageSize     = setting('comments_page_size');
        $commentsShow         = setting('comments_show', []);
        $commentsPost         = setting('comments_post', []);
        $commentsPostInterval = setting('comments_post_interval', 1);

        return admin_view(
            'options.discussion',
            compact('commentDateFormat', 'commentsListSize', 'commentsPageSize', 'commentsShow', 'commentsPost', 'commentsPostInterval')
        );
    }

    public function handleDiscussion(Request $request)
    {
        setting(['comment_date_format' => $request->input('commentDateFormat')]);
        setting(['comments_list_size' => $request->input('commentsListSize')]);
        setting(['comments_page_size' => $request->input('commentsPageSize')]);

        setting(['comments_show' => $request->input('commentsShow', [])]);

        setting(['comments_post' => $request->input('commentsPost', [])]);
        setting(['comments_post_interval' => intval($request->input('commentsPostInterval'))]);

        return redirect()->route('admin.options.discussion')->withMessage('设置已经保存');
    }

    public function showReading()
    {
        $postDateFormat = setting('post_date_format');
        $postsListSize  = setting('posts_list_size');
        $pageSize       = setting('page_size');

        return admin_view(
            'options.reading',
            compact('postDateFormat', 'postsListSize', 'pageSize')
        );
    }

    public function handleReading(Request $request)
    {
        setting(['post_date_format' => $request->get('postDateFormat')]);
        setting(['posts_list_size' => $request->get('postsListSize')]);
        setting(['page_size' => $request->get('pageSize')]);

        return redirect()->route('admin.options.reading')->withMessage('设置已经保存');
    }
}

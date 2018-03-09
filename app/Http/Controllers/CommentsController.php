<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 评论文章
     *
     * @param CommentRequest $request
     * @param                $postId
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(CommentRequest $request)
    {
        $user = auth()->user();

        // 同一 IP 发布评论的时间间隔限制
        if (in_array('comments_post_interval_enable', option('comments_post', []))) {
            if (cache()->has('comments_post_interval-' . $user->id)) {
                return back()->withErrors('你评论过于频繁，请在' . option('comments_post_interval') . '分钟后再评论');
            }

            cache()->put('comments_post_interval-' . $user->id, true, option('comments_post_interval'));
        }

        /* @var $post Post */
        $post = Post::find($request->post_id);

        if (! $post || ! $post->exists) {
            return back()->withInput()->withErrors(['text' => '文章不存在']);
        }

        $comment           = new Comment($request->all());

        // 所有评论必须经过审核
        if (in_array('comments_require_moderation', option('comments_post', []))) {
            $comment->status = Comment::STATUS_WAITING;

        // 评论者之前须有评论通过了审核
        } elseif (in_array('comments_whitelist', option('comments_post', []))) {
            if (! $user->comments()->approved()->count()) {
                $comment->status = Comment::STATUS_WAITING;
            }
        }

        $comment->owner_id = $post->user_id;

        DB::beginTransaction();

        if (! $post->comments()->save($comment)) {

            DB::rollBack();

            return back()->withInput()->withErrors(['text' => '评论失败，请刷新后重试']);
        }

        DB::commit();

        return redirect()->to(route('posts.show', $post->id) . '#comment-' . $comment->id);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        if (! $comment->delete()) {
            return back()->withErrors('评论删除失败');
        }

        return redirect()->route('posts.show', [$comment->content_id]);
    }
}

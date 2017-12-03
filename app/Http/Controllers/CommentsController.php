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
        /* @var $post Post */
        $post = Post::find($request->post_id);

        if (! $post || ! $post->exists) {
            return back()->withInput()->withErrors(['text' => '文章不存在']);
        }

        $comment           = new Comment($request->all());
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

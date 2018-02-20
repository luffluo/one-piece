<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::query();

        $post = null;
        if ($cid = $request->get('cid')) {
            $post = Post::findOrFail($cid);
            $query->where('content_id', $cid);
        }

        if ($keywords = $request->get('keywords', null)) {
            $query->where('text', 'like', "%{$keywords}%");
        }

        $waitingQuery  = clone $query;
        $spamQuery     = clone $query;
        $waiting_count = $waitingQuery->ofWaiting()->count();
        $spam_count    = $spamQuery->ofSpam()->count();

        if (! $status = $request->get('status', null)) {
            $status = Comment::STATUS_APPROVED;
        }
        $query->where('status', $status);

        $lists = $query
            ->with('user', 'post')
            ->recent()
            ->paginate(20);

        return admin_view(
            'comments.index',
            compact('lists', 'cid', 'post', 'keywords', 'status', 'waiting_count', 'spam_count')
        );
    }

    public function store(CommentRequest $request, Comment $comment)
    {
        $newComment             = new Comment([
            'text' => $request->text,
        ]);

        $newComment->owner_id   = $comment->owner_id;
        $newComment->content_id = $comment->content_id;
        $newComment->parent_id  = $comment->id;

        if (! $newComment->save()) {
            return [
                'code'    => 500,
                'message' => '未知错误',
            ];
        }

        return [
            'code'    => 200,
            'message' => 'OK',
            'comment' => [
                'text' => $newComment->content(),
            ],
        ];
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->fill($request->only('text'));

        if (! $comment->save()) {
            return [
                'code'    => 500,
                'message' => '未知错误',
            ];
        }

        return [
            'code'    => 200,
            'message' => 'OK',
            'comment' => [
                'text' => $comment->content(),
            ],
        ];
    }

    /**
     * 审核等
     *
     * @param Comment $comment
     * @param         $status
     *
     * @return $this
     */
    public function changeStatus(Request $request, Comment $comment, $status)
    {
        if (! in_array($status, [Comment::STATUS_APPROVED, Comment::STATUS_WAITING, Comment::STATUS_SPAM])) {
            return back()->withErrors('请求参数错误.');
        }

        $oldStatus = $comment->status;
        $comment->status = $status;

        if (! $comment->save()) {

            $error = '';
            switch ($status) {
                case Comment::STATUS_APPROVED:
                    $error = '评论通过失败.';
                    break;

                case Comment::STATUS_WAITING:
                    $error = '评论标记为待审核失败.';
                    break;

                case Comment::STATUS_SPAM:
                    $error = '评论标记为垃圾失败.';
                    break;
            }

            return back()->withErrors($error);
        }

        $success = '';
        switch ($status) {
            case Comment::STATUS_APPROVED:
                $success = '评论已经被通过.';
                break;

            case Comment::STATUS_WAITING:
                $success = '评论已经被标记为待审核.';
                break;

            case Comment::STATUS_SPAM:
                $success = '评论已经被标记为垃圾.';
                break;
        }

        $returnUrl = $request->headers->get('referer');
        if (empty($returnUrl)) {
            $returnUrl = route('admin.comments.index', ['status' => $oldStatus]);
        }

        return redirect()->to($returnUrl)->withSuccess($success);
    }

    public function destroy(Comment $comment)
    {
        DB::beginTransaction();

        if (! $comment->delete()) {

            DB::rollBack();

            return redirect()->route('admin.comments.index')->with('errors', "删除失败");
        }

        DB::commit();

        return redirect()->route('admin.comments.index')->with('message', "删除成功");
    }
}

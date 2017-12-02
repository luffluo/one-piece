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

        $lists = $query
            ->with('user', 'post')
            ->recent()
            ->paginate(20);

        return admin_view('comments.index', compact('lists', 'cid', 'post'));
    }

    public function reply(CommentRequest $request, Comment $parentComment)
    {
        $comment = new Comment([
            'owner_id' => $parentComment->owner_id,
            'content_id' => $parentComment->content_id,
            'text' => $request->get('text'),
            'parent_id' => $parentComment->id,
        ]);

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
                'text' => $comment->text,
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
                'text' => $comment->text,
            ],
        ];
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

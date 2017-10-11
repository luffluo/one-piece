<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index()
    {
        $query = Comment::query();

        $post = null;
        if ($cid = request()->get('cid')) {
            $post = Post::findOrFail($cid);
            $query->where('content_id', $cid);
        }

        $lists = $query
            ->with('user', 'post')
            ->recent()
            ->paginate(20);

        return admin_view('comment.index', compact('lists', 'cid', 'post'));
    }

    public function reply(CommentRequest $request, $id)
    {
        $parentComment = Comment::findOrFail($id);

        $comment = new Comment([
            'owner_id' => $parentComment->owner_id,
            'content_id' => $parentComment->content_id,
            'text' => $request->get('text'),
            'parent_id' => $parentComment->id,
        ]);

        if (! $comment->save()) {
            return response()->json([
                'code'    => 500,
                'message' => '未知错误',
            ]);
        }

        return response()->json([
            'code'    => 200,
            'message' => 'OK',
            'comment' => [
                'text' => $comment->text,
            ],
        ]);
    }

    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->fill($request->only('text'));

        if (! $comment->save()) {
            return response()->json([
                'code'    => 500,
                'message' => '未知错误',
            ]);
        }

        return response()->json([
            'code'    => 200,
            'message' => 'OK',
            'comment' => [
                'text' => $comment->text,
            ],
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        DB::beginTransaction();

        if (! $comment->delete()) {

            DB::rollBack();

            return redirect()->route('admin.comments.index')->with('errors', "删除失败");
        }

        DB::commit();

        return redirect()->route('admin.comments.index')->with('message', "删除成功");
    }
}

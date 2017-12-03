<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    public function saving(Comment $comment)
    {
        if (! $comment->exists) {
            $comment->user_id = auth()->guest() ? 1 : auth()->user()->id;
        }
    }

    public function saved(Comment $comment)
    {
        // 文章数 +1
        $comment->post->increment('comments_count');
    }

    public function deleted(Comment $comment)
    {
        // 文章数 -1
        $comment->post->decrement('comments_count');

        // 把该评论的子评论，变成该评论的父评论的子评论
        Comment::where('parent_id', $comment->id)
            ->update(['parent_id' => $comment->parent_id]);
    }
}
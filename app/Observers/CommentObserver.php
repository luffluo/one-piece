<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    public function created(Comment $comment)
    {
        // 文章数 +1
        $comment->post->increment('comments_count');
    }

    public function updated(Comment $comment)
    {
        $dirty = $comment->getDirty();

        if (isset($dirty['status'])) {

            $original = $comment->getOriginal();

            if (Comment::STATUS_APPROVED === $original['status'] && (Comment::STATUS_WAITING === $comment->status || Comment::STATUS_SPAM === $comment->status)) {
                $comment->post->decrement('comments_count');
            } elseif ((Comment::STATUS_WAITING === $original['status'] || Comment::STATUS_SPAM === $original['status']) && Comment::STATUS_APPROVED === $comment->status) {
                $comment->post->increment('comments_count');
            }
        }
    }
    
    public function saving(Comment $comment)
    {
        if (! $comment->exists) {
            $comment->user_id = auth()->guest() ? 1 : auth()->user()->id;
        }

        // XSS 过滤
        // $comment->text = clean($comment->text, 'user_comment_content');
    }

    public function saved()
    {
        $this->clearCommentCache();
    }

    public function deleted(Comment $comment)
    {
        // 文章数 -1
        $comment->post->decrement('comments_count');

        // 把该评论的子评论，变成该评论的父评论的子评论
        Comment::where('parent_id', $comment->id)
            ->update(['parent_id' => $comment->parent_id]);

        $this->clearCommentCache();
    }

    public function clearCommentCache()
    {
        cache()->forget('comment.recent');
    }
}

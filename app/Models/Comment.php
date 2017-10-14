<?php

namespace App\Models;

/**
 * Class Comment
 *
 * @property integer $id
 * @property integer $content_id 文章
 * @property integer $owner_id   文章作者
 * @property integer $user_id    评论者
 * @property string  $text       评论者
 * @property string  $type       类型
 * @property string  $status     状态 approved已通过 waiting待审核 spam垃圾
 * @property integer $parent_id  父ID
 *
 * @package App\Models
 */
class Comment extends Model
{
    const TYPE_APPROVED = 'approved';

    const TYPE_WAITING = 'waiting';

    const TYPE_SPAM = 'spam';

    protected $table = 'comments';

    protected $fillable = [
        'content_id',
        'owner_id',
        'user_id',
        'text',
        'type',
        'status',
        'parent_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($comment) {

            if (! $comment->exists) {
                $comment->user_id = auth()->guest() ? 1 : auth()->user()->id;
            }

        });

        static::saved(function ($comment) {

            // 文章数 +1
            Post::where('id', $comment->content_id)
                ->increment('comments_count');

        });

        static::deleted(function ($comment) {

            // 文章数 -1
            Post::where('id', $comment->content_id)
                ->decrement('comments_count');

            // 把该评论的子评论，变成该评论的父评论的子评论
            Comment::where('parent_id', $comment->id)
                ->update(['parent_id' => $comment->parent_id]);

        });
    }

    /**
     * 评论者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 评论的文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'content_id', 'id');
    }

    /**
     * 输出评论上 li 标签 的 class 内容
     *
     * @return string
     */
    public function liClass()
    {
        $class = '';

        if ($this->parent_id > 0) {
            $class .= ' comment-child';
        } else {
            $class .= ' comment-parent';
        }

        if ($this->user_id == $this->owner_id) {
            $class .= ' comment-by-author';
        } else {
            $class .= ' comment-by-user';
        }

        return $class;
    }

    public function content()
    {
        return $this->text;
    }
}

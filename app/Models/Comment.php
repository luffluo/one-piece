<?php

namespace App\Models;

use App\Services\Markdown;

/**
 * Class Comment
 *
 * @property integer               $id
 * @property integer               $content_id 文章
 * @property integer               $owner_id   文章作者
 * @property integer               $user_id    评论者
 * @property string                $text       评论者
 * @property string                $type       类型
 * @property string                $status     状态 approved已通过 waiting待审核 spam垃圾
 * @property integer               $parent_id  父ID
 * @property \App\Models\Post|null $post
 * @package App\Models
 */
class Comment extends Model
{
    /**
     * 通过
     */
    const STATUS_APPROVED = 'approved';

    /**
     * 待审核
     */
    const STATUS_WAITING = 'waiting';

    /**
     * 垃圾
     */
    const STATUS_SPAM = 'spam';

    protected $table = 'comments';

    protected $fillable = [
        'text',
        'parent_id',
    ];

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
     * 是通过的
     *
     * @return bool
     */
    public function isApproved()
    {
        return Comment::STATUS_APPROVED === $this->status;
    }

    /**
     * 是待审核的
     *
     * @return bool
     */
    public function isWaiting()
    {
        return Comment::STATUS_WAITING === $this->status;
    }

    /**
     * 是垃圾的
     *
     * @return bool
     */
    public function isSpam()
    {
        return Comment::STATUS_SPAM === $this->status;
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

        if ($this->user_id === $this->owner_id) {
            $class .= ' comment-by-author';
        } else {
            $class .= ' comment-by-user';
        }

        return $class;
    }

    public function content()
    {
        return $this->markdown($this->text);
    }

    public function markdown($text)
    {
        /* @var \App\Services\Markdown $markdown */
        $markdown = app()->make(Markdown::class);

        return $markdown->convert($text);
    }

    /**
     * 过滤 通过的
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * 过滤 待审核
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeOfWaiting($query)
    {
        return $query->where('status', self::STATUS_WAITING);
    }

    /**
     * 过滤 垃圾
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeOfSpam($query)
    {
        return $query->where('status', self::STATUS_SPAM);
    }
}

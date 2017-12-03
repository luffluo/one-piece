<?php

namespace App\Models;

use App\Models\Traits\MarkdownHelper;

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
    use MarkdownHelper;

    const TYPE_APPROVED = 'approved';

    const TYPE_WAITING = 'waiting';

    const TYPE_SPAM = 'spam';

    protected $table = 'comments';

    protected $fillable = [
        // 'content_id',
        // 'owner_id',
        // 'user_id',
        'text',
        // 'type',
        // 'status',
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
        return $this->parserMarkdown($this->text);
    }
}

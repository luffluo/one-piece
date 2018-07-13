<?php

namespace App\Models;

use App\Services\Markdown;

/**
 * Class Post
 *
 * @property string description
 * @property string excerpt
 *
 * @package App\Models
 */
class Post extends Content
{
    /**
     * 类型 文章
     */
    const TYPE = 'post';

    /**
     * 阅读更多标识
     */
    const MORE_FLAG = '<!--more-->';

    /**
     * 文章草稿
     */
    const TYPE_DRAFT = 'post_draft';

    protected $fillable = [
        'title',
        'slug',
        'text',
        'type',
        'status',
        'allow_comment',
        'allow_feed',
    ];

    /**
     * 应该被转换的属性
     *
     * @var array
     */
    protected $casts = [
        'allow_feed' => 'boolean',
        'allow_comment' => 'boolean',
    ];

    public $do;

    public $postTags = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * 标签
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'content_meta', 'content_id', 'meta_id');
    }

    public function setPostTags(Post $post, $tags, $beforeCount = false, $afterCount = false)
    {
        $tags = array_unique(array_map('trim', $tags));

        $existsTags = $post->tags()->get();

        // 清空已有的标签关系
        count($existsTags) > 0 && $post->tags()->sync([]);

        // 重置标签文章数
        if (count($existsTags) > 0 && $beforeCount) {
            foreach ($existsTags as $existsTag) {

                if ($existsTag->count < 1) {
                    continue;
                }

                $existsTag->count += -1;
                $existsTag->save();
            }
        }

        $insertTags = Tag::query()
            ->select('id', 'count')
            ->whereKey($tags)
            ->get();

        // 添加新标签，更新标签文章数
        if (count($insertTags) > 0) {
            $post->tags()->sync($insertTags->pluck('id'));

            if (! $afterCount) {
                return;
            }

            foreach ($insertTags as $insertTag) {
                $insertTag->count += 1;
                $insertTag->save();
            }
        }
    }

    /**
     * 作者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 评论
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'content_id', 'id');
    }

    /**
     * 附件
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'parent_id', 'id');
    }

    /**
     * 评论以 parent_id 来分组
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCommentsGroupByParentId()
    {
        return $this->comments()
            ->approved()
            ->with('user')
            ->get()
            ->groupBy('parent_id');
    }

    /**
     * 对文章的简短纯文本描述
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        $plainTxt = str_replace("\n", '', trim(strip_tags($this->excerpt)));
        $plainTxt = $plainTxt ?: $this->title;

        return str_limit($plainTxt, 100, '...');
    }

    /**
     * 获取文章摘要
     *
     * @return string
     */
    public function getExcerptAttribute()
    {
        $content  = $this->markdown($this->text);
        $contents = explode(self::MORE_FLAG, $content);
        list($excerpt) = $contents;

        return fix_html($excerpt);
    }

    /**
     * 文章内容
     *
     * @param bool $more
     *
     * @return mixed
     */
    public function content($more = false)
    {
        $string = <<<EOF
<div class="ui center aligned container more">
    <a href="%s" title="%s" role="button">%s</a>
</div>
EOF;

        if (false !== $more && false !== strpos($this->text, self::MORE_FLAG)) {
            return $this->excerpt . sprintf($string, route('posts.show', ['id' => $this->id]), $this->title, $more);
        }

        return $this->markdown($this->text);
    }

    /**
     * 输出文章摘要
     *
     * @param int    $length 摘要截取长度
     * @param string $end    摘要后缀
     *
     * @return string
     */
    public function excerpt($length = 100, $end = '...')
    {
        return str_limit(strip_tags($this->excerpt), $length, $end);
    }

    /**
     * 输出标题
     *
     * @param int    $length 标题截取长度
     * @param string $end    截取后缀
     *
     * @return string
     */
    public function headline($length = 0, $end = '...')
    {
        return $length > 0 ? str_limit($this->title, $length, $end) : $this->title;
    }

    /**
     * 输出文章评论数
     *
     * @param array ...$args
     *
     * @return string
     */
    public function commentsNum(...$args)
    {
        if (! $args) {
            $args[] = '%d';
        }

        $num = intval($this->comments_count);

        return sprintf($args[$num] ?? array_pop($args), $num);
    }

    /**
     * markdown 解析
     *
     * @param mixed $text
     *
     * @return string
     */
    public function markdown($text)
    {
        /* @var \App\Services\Markdown $markdown */
        $markdown = app()->make(Markdown::class);

        return $markdown->convert($text);
    }

    /**
     * 同步附件
     *
     * @access protected
     *
     * @param integer $cid 内容id
     *
     * @return void
     */
    public function attach()
    {
        $attachments = request()->get('attachment');
        if (! empty($attachments)) {
            foreach ($attachments as $key => $attachment) {
                Attachment::query()
                    ->where('id', $attachment)
                    ->update([
                        'parent_id' => $this->id,
                        'status'    => static::STATUS_PUBLISH,
                        'order'     => $key + 1,
                    ]);
            }
        }
    }

    /**
     * 过滤 文章和文章草稿
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopePostAndDraft($query)
    {
        return $query->where(function ($query) {
            return $query->where('type', static::TYPE)
                ->orWhere('type', static::TYPE_DRAFT);
        });
    }

    /**
     * 过滤 发布的
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('type', static::TYPE);
    }

    /**
     * 过滤 草稿
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeDraft($query)
    {
        return $query->where('type', static::TYPE_DRAFT);
    }

    /**
     * 过滤 允许聚合
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeAllowFeed($query)
    {
        return $query->where('allow_feed', '=', 1);
    }
}

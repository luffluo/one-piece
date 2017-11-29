<?php

namespace App\Models;

class Post extends Content
{
    /**
     * 类型 文章
     */
    const TYPE = 'post';

    /**
     * 文章草稿
     */
    const TYPE_DRAFT = 'post_draft';

    /**
     * @var \Parsedown
     */
    protected static $markdown;

    protected $fillable = [
        'title',
        'slug',
        'text',
        'user_id',
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
    ];

    public $do;

    public $postTags = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function setPostTags($post, $tags, $beforeCount = false, $afterCount = false)
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
            ->whereIn('id', $tags)
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

    public static function setMarkdown($markdown)
    {
        static::$markdown = $markdown;
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
     * 评论以 parent_id 来分组
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getComments()
    {
        return $this->comments()->with('user')->get()->groupBy('parent_id');
    }

    /**
     * 文章标题
     *
     * @param int    $length
     * @param string $trim
     *
     * @return string
     */
    public function headline($length = 0, $trim = '...')
    {
        return $length > 0 ? str_limit($this->title, $length, $trim) : $this->title;
    }

    /**
     * 文章摘要
     *
     * @return string
     */
    public function summary()
    {
        $plainTxt = str_replace("\n", '', trim(strip_tags($this->parserContent())));
        $plainTxt = $plainTxt ?: $this->title;

        return str_limit($plainTxt);
    }

    /**
     * 解析 md 格式的文章
     *
     * @return string
     */
    public function parserContent()
    {
        return static::$markdown
            ->setMarkupEscaped(true)
            ->text($this->text);
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
<p class="more">
    <a href="%s" role="button">%s</a>
</p>
EOF;

        mb_strlen($this->text) < 100 && $more = false;

        return false !== $more ?
            sprintf('<p>%s</p>', $this->summary()) . sprintf($string, route('post.show', ['id' => $this->id]), $more)
            : $this->parserContent();
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

    public function scopePostAndDraft($query)
    {
        return $query->where(function ($query) {
            return $query->where('type', static::TYPE)
                ->orWhere('type', static::TYPE_DRAFT);
        });
    }

    public function scopePublished($query)
    {
        return $query->where('type', static::TYPE);
    }

    public function scopeDraft($query)
    {
        return $query->where('type', static::TYPE_DRAFT);
    }

    public function scopeAllowFeed($query)
    {
        return $query->where('allow_feed', '=', 1);
    }
}

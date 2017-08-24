<?php

namespace App\Models;

use Carbon\Carbon;

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
     * 私密
     */
    const STATUS_PRIVATE = 'private';

    /**
     * @var \HyperDown\Parser
     */
    protected static $parser;

    protected $fillable = [
        'title',
        'slug',
        'text',
        'user_id',
        'type',
        'status',
        'published_at',
        // 'do',
        // 'visibility',
    ];

    public $do;

    // public $visibility;

    protected $dates = [
        'published_at',
    ];

    /*protected $appends = [
        'do', 'visibility',
    ];*/

    public static function boot()
    {
        parent::boot();

        static::saving(function ($post) {

            if ($post->exists) {
                $post->user_id = auth()->user()->id;
            }

            if ('publish' == $post->do) {
                $post->type = static::TYPE;
            } else {
                $post->type = static::TYPE_DRAFT;
            }

            // if (empty($post->visibility)) {
            //     $post->status = static::TYPE;
            // } else {
            //     $post->status = $post->visibility;
            // }

        });

        static::saved(function ($post) {

            if ($post->id > 0) {
                if ($post->wasRecentlyCreated) {

                    if ('publish' == $post->do) {
                        $isDraftToPublish = false;
                        $isBeforePublish  = false;
                        $isAfterPublish   = true;
                    } else {
                        $isDraftToPublish = false;
                        $isBeforePublish  = false;
                        $isAfterPublish   = false;
                    }

                } else {
                    $originalAttributes = $post->getOriginal();
                    if ('publish' == $post->do) {

                        // 是否是从草稿状态发布
                        $isDraftToPublish = static::TYPE_DRAFT == $originalAttributes['type'] && static::TYPE == $post->type;

                        // 以前是否是发布的
                        $isBeforePublish  = static::TYPE == $originalAttributes['type'];

                        // 当前是否是发布
                        $isAfterPublish = static::TYPE == $post->type;

                    } else {

                        $isDraftToPublish = static::TYPE_DRAFT == $originalAttributes['type'] && static::TYPE == $post->type;
                        $isBeforePublish  = static::TYPE == $originalAttributes['type'];
                        $isAfterPublish   = false;

                    }
                }

                // dump($post->getOriginal(), $post, $isDraftToPublish, $isBeforePublish, $isAfterPublish);

                $post->setPostTags(
                    $post,
                    request()->input('tags', []),
                    !$isDraftToPublish && $isBeforePublish,
                    $isAfterPublish
                );
            }

        });

        static::deleted(function ($post) {

            // 减去对应标签的文章数
            $tags = $post->tags()->get();
            if (count($tags) > 0) {
                foreach ($tags as $tag) {
                    if ($tag->count > 0) {
                        $tag->count += -1;
                        $tag->save();
                    }
                }
            }

            // 删除文章和标签的所有关联
            $post->tags()->sync([]);
        });
    }

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
        static::$parser = $markdown;
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = empty($value) ? $this->freshTimestamp() : $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 文章标题
     *
     * @param int    $length
     * @param string $trim
     *
     * @return string
     */
    public function getTitle($length = 0, $trim = '...')
    {
        return $length > 0 ? str_limit($this->title, $length, $trim) : $this->title;
    }

    /**
     * 解析 md 格式的文章
     *
     * @return string
     */
    public function parserContent()
    {
        return static::$parser->makeHtml($this->text);
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
        $string = '<p class="pull-right"><a href="%s" class="btn btn-default" role="button">%s</a></p>';

        return false !== $more ?
            $this->summary() . sprintf($string, route('post.show', ['id' => $this->id]), $more)
            : $this->parserContent();
    }

    /**
     * 文章摘要
     *
     * @return string
     */
    public function summary()
    {
        $plainTxt = str_replace("\n", '', trim(strip_tags($this->content())));
        $plainTxt = $plainTxt ?: $this->title;

        return str_limit($plainTxt);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('type', static::TYPE)
            ->where('status', 'publish');
            // ->where('published_at', '>', Carbon::now());
    }
}

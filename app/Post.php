<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/2/12
 * Time: 上午11:05
 */

namespace App;

class Post extends Content
{
    const TYPE = 'post';

    /**
     * @var \HyperDown\Parser
     */
    protected static $parser;

    protected $fillable = [
        'title',
        'slug',
        'text',
        'user_id',
        'status',
        'type',
        'published_at',
    ];

    protected $dates = [
        'published_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->user_id = auth()->user()->id;
        });
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
    public function title($length = 0, $trim = '...')
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
}

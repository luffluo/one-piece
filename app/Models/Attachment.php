<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Attachment extends Content
{
    const TYPE = 'attachment';

    protected $fillable = [
        'title',
        'slug',
        'text',
        'type',
        'status',
        'parent_id'
    ];

    protected $casts = [
        'text' => 'array',
    ];

    /**
     * 数据模型的启动方法
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // 只查询出和当前 Model TYPE 相同的数据
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', static::TYPE);
        });
    }

    /**
     * 上传者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * 所属文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'parent_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->text['name'] ?? '';
    }

    public function getUrlAttribute()
    {
        return $this->text['url'] ?? asset($this->text['path']);
    }

    public function getDescriptionAttribute()
    {
        return $this->text['description'] ?? '';
    }

    /**
     * 删除文件
     *
     * @return bool
     */
    public function deleteFile()
    {
        return @unlink(public_path($this->text['path']));
    }
}

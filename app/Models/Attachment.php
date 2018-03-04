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
}

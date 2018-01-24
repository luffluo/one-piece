<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Nav extends Content
{
    const TYPE = 'nav';

    protected $fillable = [
        'title',
        'slug',
        'text',
        'order',
        'type',
        'status',
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

    public function scopeShow($query)
    {
        return $query->where('status', static::STATUS_PUBLISH);
    }
}

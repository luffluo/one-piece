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

    public static function boot()
    {
        parent::boot();

        // 只查询出和当前 Model TYPE 相同的数据
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', static::TYPE);
        });
    }
}

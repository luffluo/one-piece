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

        static::saving(function ($nav) {

            $navCount = self::query()
                ->count();

            if ($nav->exists) {

                /**
                 * 给导航自动排序
                 * 思路：
                 * 分两种情况：新增和编辑
                 * 新增分两种情况：1. 当用户填了一个数字，我只要找出比这个数字大的那些数据，把它们的 order +1 就行了
                 * 2. 当用户没有填写或填写的数字超出了当前数字的范围 +1, 那就默认设为最大条数 +1
                 *
                 * 编辑分两种: 1. 当用户填写了一个超出范围的值，那顺序不变
                 * 2. 当用户填了一个更大值时，只要让数据表把 old < () <= new 这个范围的值 -1
                 *    当用户添了一个比原来小的值时，只要让数据表把 new <= () < old 这个范围的值 +1
                 */
                $oldOrder = $nav->getOriginal('order');

                if (empty($nav->order) || $nav->order > $navCount || $nav->order < 1) {
                    $nav->order = $oldOrder;
                } else {

                    // 如 2(oldOrder) 变为 5(newOrder)， 就把 3, 4, 5 往上挤变为 2, 3, 4
                    if ($nav->order > $oldOrder) {
                        Nav::where('type', static::TYPE)
                            ->where('order', '>', $oldOrder)
                            ->where('order', '<=', $nav->order)
                            ->decrement('order');

                    // 如 5(oldOrder) 变为 2(newOrder)， 就把 2, 3, 4 往下挤变为 3, 4, 5
                    } elseif ($nav->order < $oldOrder) {

                        Nav::where('type', static::TYPE)
                            ->where('order', '<', $oldOrder)
                            ->where('order', '>=', $nav->order)
                            ->increment('order');

                    }
                }


            } else {

                if ($nav->order && $nav->order <= $navCount && $nav->order >= 1) {

                    Nav::where('type', static::TYPE)
                        ->where('order', '>=', $nav->order)
                        ->increment('order');

                } else {
                    $nav->order = $navCount + 1;
                }

            }

        });

        static::deleted(function ($nav) {

            Nav::where('type', static::TYPE)
                ->where('order', '>', $nav->order)
                ->decrement('order');

        });

        // 只查询出和当前 Model TYPE 相同的数据
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', static::TYPE);
        });
    }

    public static function lastNavByOrder()
    {
        return self::select('id', 'title', 'order')
            ->orderDesc()
            ->first();
    }
}

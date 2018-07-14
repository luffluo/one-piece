<?php

namespace App\Models;

/**
 * Class Content
 *
 * @property integer             $id
 * @property integer             $user_id
 * @property string              $title
 * @property string              $slug
 * @property string              $text
 * @property string              $type
 * @property string              $status
 * @property integer             $views_count
 * @property integer             $comments_count
 * @property boolean             $allow_feed
 * @property boolean             $allow_comment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $published_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @package App
 */
abstract class Content extends Model
{
    /**
     * 发布
     */
    const STATUS_PUBLISH = 'publish';

    protected $table = 'contents';

    public function scopeOrderAsc($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeOrderDesc($query)
    {
        return $query->orderBy('order', 'desc');
    }
}

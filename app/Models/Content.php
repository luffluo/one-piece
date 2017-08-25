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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'relationships', 'content_id', 'meta_id');
    }
}

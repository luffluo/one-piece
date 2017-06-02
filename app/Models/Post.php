<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/2/12
 * Time: 上午11:05
 */
namespace App\Models;

/**
 * Class Post
 *
 * @property integer             $id
 * @property string              $title
 * @property string              $text
 * @property string              $type
 * @property string              $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $published_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @package App\Models
 */
class Post extends Content
{
    const TYPE = 'post';

    protected $fillable = [
        'title', 'slug', 'text', 'user_id', 'status', 'type', 'published_at',
    ];

    protected $dates = [
        'published_at'
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //
    //     static::creating(function ($post) {
    //         if (empty($post->published_at)) {
    //             $post->published_at = $post->freshTimestamp();
    //         }
    //     });
    // }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = empty($value) ? $this->freshTimestamp() : $value;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Content extends Model
{
    protected $table = 'contents';

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'relationships', 'content_id', 'meta_id');
    }
}

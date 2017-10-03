<?php

namespace App\Models;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'content_id',
        'owner_id',
        'user_id',
        'text',
        'type',
        'status',
        'parent_id'
    ];
}

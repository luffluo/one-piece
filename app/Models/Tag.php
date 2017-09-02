<?php

namespace App\Models;

class Tag extends Meta
{
    const TYPE = 'tag';

    public function scopeHadPosts($query)
    {
        return $query->where('count', '>', 0);
    }
}

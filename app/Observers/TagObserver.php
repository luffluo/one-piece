<?php

namespace App\Observers;

use App\Models\Tag;

class TagObserver
{
    public function saved()
    {
        $this->clearTagsCache();
    }

    public function deleted(Tag $tag)
    {
        // 删除文章标签关系
        $tag->posts()->sync([]);

        $this->clearTagsCache();
    }

    protected function clearTagsCache()
    {
        cache()->forget('tags.had_posts');
    }
}

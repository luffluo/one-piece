<?php

namespace App\Observers;

use App\Models\Tag;

class TagObserver
{
    public function saved()
    {
        $this->clearTagsCache();
    }

    public function deleted()
    {
        $this->clearTagsCache();
    }

    protected function clearTagsCache()
    {
        cache()->forget('tags.had_posts');
    }
}

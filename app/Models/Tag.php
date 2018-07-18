<?php

namespace App\Models;

class Tag extends Meta
{
    const TYPE = 'tag';

    public function scopeHadPosts($query)
    {
        return $query->where('count', '>', 0);
    }

    public static function scanTags($inputTags)
    {
        $tags = is_array($inputTags) ? $inputTags : (array) $inputTags;

        $result = Tag::query()
            ->select('id', 'name', 'count')
            ->whereIn('name', $tags)
            ->get();

        $notExistsTags = collect($tags)->diff($result->pluck('name'))->toArray();
        foreach ($notExistsTags as $notExistsTag) {
            $tag = null;
            if ($slug = slug_name($notExistsTag)) {
                $tag = Tag::create([
                    'name' => $notExistsTag,
                    'slug' => $slug,
                ]);
            }

            if ($tag) {
                $result->push($tag);
            }
        }

        return $result;
    }
}

<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    public function created(Post $post)
    {
        cache()->forget('sitemap');
        cache()->forget('post.feed');
        cache()->forget('post.archive');
    }

    public function updated(Post $post)
    {
        cache()->forget('sitemap');
        cache()->forget('post.feed');
    }

    public function saving(Post $post)
    {
        if (! $post->exists) {
            $post->user_id = auth()->guest() ? 1 : auth()->user()->id;
        }

        if (! empty($post->do)) {
            $post->type = 'publish' == $post->do ? Post::TYPE : Post::TYPE_DRAFT;
        }
    }

    public function saved(Post $post)
    {
        if ($post->id > 0 && ! empty($post->do)) {
            if ($post->wasRecentlyCreated) {

                if ('publish' == $post->do) {
                    $isDraftToPublish = false;
                    $isBeforePublish  = false;
                    $isAfterPublish   = true;
                } else {
                    $isDraftToPublish = false;
                    $isBeforePublish  = false;
                    $isAfterPublish   = false;
                }

            } else {
                $originalAttributes = $post->getOriginal();
                if ('publish' == $post->do) {

                    // 是否是从草稿状态发布
                    $isDraftToPublish = Post::TYPE_DRAFT == $originalAttributes['type'] && Post::TYPE == $post->type;

                    // 以前是否是发布的
                    $isBeforePublish = Post::TYPE == $originalAttributes['type'];

                    // 当前是否是发布
                    $isAfterPublish = Post::TYPE == $post->type;

                } else {

                    $isDraftToPublish = Post::TYPE_DRAFT == $originalAttributes['type'] && Post::TYPE == $post->type;
                    $isBeforePublish  = Post::TYPE == $originalAttributes['type'];
                    $isAfterPublish   = false;

                }
            }

            $post->setPostTags(
                $post,
                $post->postTags,
                ! $isDraftToPublish && $isBeforePublish,
                $isAfterPublish
            );
        }
    }

    public function deleted(Post $post)
    {
        // 减去对应标签的文章数
        $tags = $post->tags()->get();
        if (count($tags) > 0) {
            foreach ($tags as $tag) {
                if ($tag->count > 0) {
                    $tag->count += -1;
                    $tag->save();
                }
            }
        }

        // 删除文章和标签的所有关联
        $post->tags()->sync([]);

        cache()->forget('sitemap');
        cache()->forget('post.feed');
        cache()->forget('post.archive');
    }
}

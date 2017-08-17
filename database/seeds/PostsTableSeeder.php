<?php

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = factory(Post::class)->times(33)->make();
        Post::insert($posts->toArray());

        $posts = Post::query()->select('id')->get();

        $tags = Tag::query()->select('id')->get();

        $posts->map(function ($post) use ($tags) {

            // 随机几个标签
            $randomTags = $tags->random(mt_rand(1, $tags->count()));

            // 给当前文章添加上随机出来的标签
            $post->tags()->sync($randomTags->pluck('id')->all());

            // 给标签的文章数 +1
            $randomTags->map(function($tag) {
               $tag->count += 1;
               $tag->save();
            });

        });

        $this->command->info("生成 {$posts->count()} 篇文章.");
    }
}

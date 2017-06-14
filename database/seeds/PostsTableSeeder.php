<?php

use App\Models\User;
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

        $this->command->info("生成 {$posts->count()} 篇文章.");
    }
}

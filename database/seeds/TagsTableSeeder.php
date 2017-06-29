<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagNames = [
            'PHP', 'Laravel', 'Composer', 'Git', 'HTML', 'Homestead',
            'OOP', 'PhpStorm', 'MySql', 'JavaScript'
        ];

        $i = 0;

        array_map(function ($tagName) use (& $i) {

            $tag = new Tag(['name' => $tagName]);
            $tag->slug = slug_name($tagName);
            $tag->save() && $i++;

        }, $tagNames);

        $this->command->info("生成 {$i} 个标签");
    }
}

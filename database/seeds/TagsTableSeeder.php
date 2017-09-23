<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;

        (new Collection([
            'Luff', 'PHP', 'Laravel', 'Composer', 'Git', 'HTML',
            'Homestead', 'OOP', 'PhpStorm', 'MySql', 'JavaScript'
        ]))->map(function($tagName) use (&$i) {
            $tag = new Tag(['name' => $tagName]);
            $tag->slug = slug_name($tagName);
            $tag->save() && $i++;
        });

        $this->command->info("生成 {$i} 个标签");
    }
}

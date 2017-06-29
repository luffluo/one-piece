<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(5)->make();
        User::insert($users->toArray());

        $user           = User::find(1);
        $user->name     = 'luff';
        $user->email    = 'luff@luff.life';
        $user->nickname = 'Luff';
        $user->save();

        $this->command->info("生成 {$users->count()} 个用户.");
    }
}

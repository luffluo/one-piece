<?php

use App\Models\User;
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
        $users = factory(User::class)->times(50)->make();
        User::insert($users->toArray());

        $user           = User::find(1);
        $user->username = 'luff';
        $user->email    = 'luff@luff.life';
        $user->nickname = 'Luff';
        $user->save();

        $this->command->info("生成 {$users->count()} 个用户");
    }
}

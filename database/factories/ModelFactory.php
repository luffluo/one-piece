<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    $dateTime = $faker->dateTime;

    return [
        'name'       => $faker->userName,
        'email'          => $faker->unique()->safeEmail,
        'avatar'         => '',
        'nickname'       => $faker->name,
        'password'       => bcrypt('123456'),
        'remember_token' => str_random(10),
        'created_at'     => $dateTime,
        'updated_at'     => $dateTime,
        'activated_at'   => $dateTime,
        'last_seen_time' => $dateTime,
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    $dateTime = $faker->dateTime;

    return [
        'title'          => $faker->sentence,
        'text'           => $faker->paragraph,
        'slug'           => $faker->uuid,
        'user_id'        => 1,
        'status'         => '',
        'type'           => 'post',
        'created_at'     => $dateTime,
        'updated_at'     => $dateTime,
        'published_at'   => $dateTime,
    ];
});

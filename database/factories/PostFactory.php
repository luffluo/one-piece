<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Post::class, function (Faker $faker) {
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
    ];
});

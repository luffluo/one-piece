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
        'username'       => $faker->userName,
        'email'          => $faker->unique()->safeEmail,
        'avatar'         => '',
        'nickname'       => $faker->name,
        'password'       => bcrypt('secret'),
        'remember_token' => str_random(10),
        'created_at'     => $dateTime,
        'updated_at'     => $dateTime,
        'activated_at'   => $dateTime,
        'last_seen_time' => $dateTime,
    ];
});

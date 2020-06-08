<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\UserProfile;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'name' => $faker->name,
        'introduction' =>  $faker->paragraph(2),
        // 'avatar' => $faker->randomElement([
        //     null,
        //     'https://i.ya-webdesign.com/images/teacher-clip-filipino-3.png',
        //     'https://p7.hiclipart.com/preview/118/942/565/computer-icons-avatar-child-user-avatar.jpg',
        //     'https://secure.i.telegraph.co.uk/multimedia/archive/03491/Vladimir_Putin_1_3491835k.jpg'
        // ]),
        'facebook' => $faker->boolean(50) ? $faker->url() : null,
        'twitter' => $faker->boolean(50) ? $faker->url() : null,
        'instagram' => $faker->boolean(50) ? $faker->url() : null,
        'remember_token' => Str::random(10),
    ];
});

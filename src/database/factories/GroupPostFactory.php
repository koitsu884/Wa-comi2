<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Group;
use App\Models\GroupPost;
use Faker\Generator as Faker;

$factory->define(GroupPost::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'group_id' => Group::all()->random()->id,
        'title' => $faker->word,
        'content' => $faker->paragraph(4),
        'youtube' => $faker->boolean(30) ? 'https://www.youtube.com/watch?v=zs7Jw5tlTCw' : null
    ];
});

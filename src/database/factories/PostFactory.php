<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Area;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\PostCategory;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'post_category_id' => PostCategory::all()->random()->id,
        'area_id' => $faker->boolean(80) ? Area::all()->random()->id : null,
        'title' => $faker->word,
        'content' => $faker->paragraph(2),
    ];
});

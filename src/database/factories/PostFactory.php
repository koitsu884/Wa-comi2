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
        'main_image' => $faker->boolean(80) ? $faker->randomElement([
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2020/05/DSC_0720.jpg',
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2020/05/DSC_0734.jpg',
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2018/01/DSC08407.jpg',
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2018/03/DSC02450.jpg',
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2018/03/DSC08071.jpg'
        ]) : null,
    ];
});

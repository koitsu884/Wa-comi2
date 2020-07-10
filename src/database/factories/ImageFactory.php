<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Post;
use App\Models\Group;
use App\Models\Image;
use App\Models\GroupPost;
use App\Models\GroupMember;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    $imagenableType =  $faker->randomElement([
        Group::class,
        Post::class,
        GroupPost::class,
    ]);

    $imagenableId = 0;
    $user_id = 0;

    switch($imagenableType){
        case Group::class:
            $imagenableId = Group::all()->random()->id;
            $user_id = GroupMember::where('group_id', $imagenableId)
                ->inRandomOrder()
                ->first()
                ->user_id;
            break;
        case GroupPost::class:
            $groupPost = GroupPost::all()->random();
            $imagenableId = $groupPost->id;
            $user_id = $groupPost->user_id;
            break;
        default: 
            $post = Post::all()->random();
            $imagenableId = $post->id;
            $user_id = $post->user_id;
    }
    // if ($imagenableType == Group::class) {
    //     $imagenableId = Group::all()->random()->id;
    //     $user_id = GroupMember::where('group_id', $imagenableId)
    //         ->inRandomOrder()
    //         ->first()
    //         ->user_id;
    // } else {
    //     $post = Post::all()->random();
    //     $imagenableId = $post->id;
    //     $user_id = $post->user_id;
    // }

    return [
        'user_id' => $user_id,
        'imageable_type' => $imagenableType,
        'imageable_id' => $imagenableId,
        'is_main' => !Image::where(['imageable_type' => $imagenableType, 'imageable_id' => $imagenableId])->exists(),
        'url' => $faker->randomElement([
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2020/05/DSC_0720.jpg',
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2020/05/DSC_0734.jpg',
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2018/01/DSC08407.jpg',
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2018/03/DSC02450.jpg',
            'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads/2018/03/DSC08071.jpg'
        ]),
        'path' => 'https://koitsutohitsuzi.xyz/wordpress/wp-content/uploads',
    ];
});

$factory->state(Image::class, 'post', function (Faker $faker) {
    return [
        'imageable_type' => Post::class,
        'imageable_id' => Post::all()->random()->id,
    ];
});

$factory->state(Image::class, 'group', function (Faker $faker) {
    return [
        'imageable_type' => Group::class,
        'imageable_id' => Group::all()->random()->id,
    ];
});

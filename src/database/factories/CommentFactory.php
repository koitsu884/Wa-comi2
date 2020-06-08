<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $commentableType =  $faker->randomElement([
        Post::class,
    ]);

    $commentableId = 0;
    $user_id = 0;

    // if ($commentableType == Group::class) {
    //     $commentableId = Group::all()->random()->id;
    //     $user_id = GroupMember::where('group_id', $commentableId)->random()->user_id;
    // } else {
    $post = Post::all()->random();
    $commentableId = $post->id;
    $user_id = User::all()->random()->id;
    // }

    return [
        'user_id' => $user_id,
        'commentable_type' => $commentableType,
        'commentable_id' => $commentableId,
        'comment' => $faker->paragraph(1),
    ];
});

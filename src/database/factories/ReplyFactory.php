<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Reply;
use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    $comment = Comment::all()->random();
    $user_id = User::all()->random()->id;
    // }

    return [
        'user_id' => $user_id,
        'comment_id' => $comment->id,
        'reply' => $faker->paragraph(1),
    ];
});

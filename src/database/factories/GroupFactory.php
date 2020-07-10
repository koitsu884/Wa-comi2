<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Area;
use App\Models\Group;
use App\Models\GroupCategory;
use App\Models\GroupMember;
use App\Models\Image;
use App\User;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'slug' => str_slug( $faker->unique()->sentence()),
        'user_id' => User::all()->random()->id,
        'area_id' => $faker->boolean(80) ? Area::all()->random()->id : null,
        'is_public' => $faker->boolean(),
        'group_category_id' => GroupCategory::all()->random()->id,
        'name' => $faker->word,
        'description' => $faker->paragraph(3),
        'homepage' => $faker->boolean(50) ? $faker->url() : null,
        'facebook' => $faker->boolean(50) ? $faker->url() : null,
        'twitter' => $faker->boolean(50) ? $faker->url() : null,
        'instagram' => $faker->boolean(50) ? $faker->url() : null,
    ];
});

$factory->define(GroupMember::class, function (Faker $faker) {
    return [
        'group_id' => Group::all()->random()->id,
        'user_id' => User::all()->random()->id,
        'invited_by' => User::all()->random()->id,
        'role' => $faker->boolean(95) ? 'member' : 'organizer',
    ];
});

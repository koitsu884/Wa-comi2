<?php

use App\Models\Comment;
use App\Models\Group;
use App\Models\GroupImage;
use App\Models\GroupMember;
use App\Models\Image;
use App\User;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Comment::truncate();
        Post::truncate();
        Image::truncate();
        GroupMember::truncate();
        Group::truncate();

        $usersQuantity = 100;
        $postQuantity = 30;
        $groupQuantity = 10;
        $commentQuantity = 50;
        $imageQuantity = 100;

        factory(User::class)->create([
            'email' => 'admin@gmail.com',
            'admin' => true,
            'name' => 'Admin',
        ]);

        factory(User::class, $usersQuantity)->create();

        factory(Post::class, $postQuantity)->create();

        factory(Group::class, $groupQuantity)->create()->each(function ($group) {
            $ownerId = $group->user_id;
            factory(GroupMember::class)->create([
                'user_id' => $ownerId,
                'group_id' => $group->id,
                'role' => 'owner',
                'created_by' => $ownerId
            ]);

            $memberCount = rand(0, 100);
            $userIds = range(1, User::all()->count() + 1);
            shuffle($userIds);
            for ($i = 0; $i < $memberCount; $i++) {
                $userId = $userIds[$i];
                if ($userId != $ownerId) {
                    factory(GroupMember::class)->create([
                        'user_id' => $userId,
                        'group_id' => $group->id,
                        'created_by' => $ownerId
                    ]);
                }
            }

            // if ($memberCount > 1) {
            //     $imageCount = rand(0, 100);

            //     for ($i = 0; $i < $imageCount; $i++) {
            //         // factory(GroupImage::class)->create([
            //         //     'group_id' => $group->id,
            //         //     'user_id' =>  $userIds[rand(0, $memberCount - 1)],
            //         // ]);
            //         factory(Image::class)->states('group')->create([
            //             'imageable_id' => $group->id,
            //             'user_id' =>  $userIds[rand(0, $memberCount - 1)],
            //         ]);
            //     }
            // }
        });

        factory(Image::class, $imageQuantity)->create();
        factory(Comment::class, $commentQuantity)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

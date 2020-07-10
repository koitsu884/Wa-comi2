<?php

use App\User;
use App\Models\Post;
use App\Models\Group;
use App\Models\Image;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\GroupMember;
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
        Reply::truncate();
        Post::truncate();
        Image::truncate();
        GroupMember::truncate();
        Group::truncate();
        GroupPost::truncate();

        $usersQuantity = 100;
        $postQuantity = 30;
        $groupQuantity = 10;
        $commentQuantity = 50;
        $replyQuantity = 200;
        $imageQuantity = 150;

        factory(User::class)->create([
            'email' => 'admin@gmail.com',
            'admin' => true,
            'name' => 'Admin',
        ]);

        factory(User::class, $usersQuantity)->create();

        factory(Post::class, $postQuantity)->create();

        factory(Group::class, $groupQuantity)->create()->each(function ($group) {
            $ownerId = $group->user_id;
            $memberCount = rand(0, 100);
            $userCount = User::all()->count() + 1;
            $userIds = range(1, $userCount);
            $memberIds = [];
            shuffle($userIds);
            for ($i = 0; $i < $memberCount; $i++) {
                $userId = $userIds[$i];
                if ($userId != $ownerId) {
                    factory(GroupMember::class)->create([
                        'user_id' => $userId,
                        'group_id' => $group->id,
                        'invited_by' => $ownerId
                    ]);
                }
                array_push($memberIds, $userId);
            }

            $postCount = rand(0,10);
            for( $i=0; $i<$postCount; $i++){
                factory(GroupPost::class)->create([
                    'group_id' => $group->id,
                    'user_id' => $memberIds[rand(0, count($memberIds) - 1)]
                ]);
            }
        });

        factory(Image::class, $imageQuantity)->create();
        factory(Comment::class, $commentQuantity)->create();
        factory(Reply::class, $replyQuantity)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

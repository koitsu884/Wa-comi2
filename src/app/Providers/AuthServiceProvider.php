<?php

namespace App\Providers;

use App\User;
use App\Models\Post;
use App\Models\Group;
use App\Models\Reply;
use App\Models\GroupPost;
use App\Models\PostImage;
use App\Models\UserImage;
use App\Models\GroupImage;
use App\Models\GroupMember;
use App\Models\PostComment;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\GroupPolicy;
use App\Policies\ReplyPolicy;
use App\Models\UserInvitation;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use App\Models\GroupInvitation;
use App\Policies\GroupPostPolicy;
use App\Policies\PostImagePolicy;
use App\Policies\UserImagePolicy;
use App\Policies\GroupImagePolicy;
use App\Policies\GroupMemberPolicy;
use App\Policies\PostCommentPolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserInvitationPolicy;
use App\Policies\GroupInvitationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Group::class => GroupPolicy::class,
        GroupInvitation::class => GroupInvitationPolicy::class,
        GroupPost::class => GroupPostPolicy::class,
        UserInvitation::class => UserInvitationPolicy::class,
        GroupMember::class => GroupMemberPolicy::class,
        User::class => UserPolicy::class,
        UserImage::class => UserImagePolicy::class,
        PostImage::class => PostImagePolicy::class,
        GroupImage::class => GroupImagePolicy::class,
        PostComment::class => PostCommentPolicy::class,
        Reply::class => ReplyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('update-post-mainimage', function($user, $post, $image){
        //     if($user->id !== $post->user_id)
        //         return false;
        //     $relatingModel = $image->imageable()->first();
        //     return $post->id === $relatingModel->id;
        // });
        Gate::define('update-post-mainimage', 'App\Policies\PostImagePolicy@update');
        Gate::define('update-group-mainimage', 'App\Policies\GroupImagePolicy@update');
        // Gate::define('users.posts.update', 'App\Policies\PostPolicy@update');
        // Gate::define('users.posts.delete', 'App\Policies\PostPolicy@delete');

        // Gate::before(function ($user, $ability) {
        //     if ($user->isAdmin() && in_array($ability, ['users.posts.delete'])) {
        //         return true;
        //     }
        // });

        Passport::routes();

        Passport::tokensExpireIn(Carbon::now()->addMinutes(10));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(7));
    }
}

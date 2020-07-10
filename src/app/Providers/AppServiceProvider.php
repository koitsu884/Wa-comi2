<?php

namespace App\Providers;

use App\User;
use App\Models\Post;
use App\Models\Image;
use App\Models\GroupPost;
use App\Models\GroupMember;
use App\Models\UserInvitation;
use App\Models\GroupInvitation;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use App\Observers\ImageObserver;
use App\Services\AwsImageManager;
use App\Observers\GroupPostObserver;
use App\Observers\GroupMemberObserver;
use Illuminate\Support\Facades\Schema;
use App\Contracts\ImageManagerContract;
use Illuminate\Support\ServiceProvider;
use App\Observers\UserInvitationObserver;
use App\Observers\GroupInvitationObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(
            'App\Contracts\ImageManagerContract',
            AwsImageManager::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        User::observe(UserObserver::class);
        Post::observe(PostObserver::class);
        UserInvitation::observe(UserInvitationObserver::class);
        GroupMember::observe(GroupMemberObserver::class);
        GroupInvitation::observe(GroupInvitationObserver::class);
        GroupPost::observe(GroupPostObserver::class);
        Image::observe($this->app->make(ImageObserver::class));
    }
}

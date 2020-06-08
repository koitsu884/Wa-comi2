<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
use App\Policies\UserImagePolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        User::class => UserPolicy::class,
        UserImage::class => UserImagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

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

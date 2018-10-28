<?php

namespace App\Providers;

use App\Models;
use App\Policies;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\User::class    => Policies\UserPolicy::class,
        Models\Comment::class => Policies\CommentPolicy::class,
        Models\Post::class    => Policies\PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 是否能进入后台
        Gate::define('enter-admin-dashboard', '\App\Policies\UserPolicy@enterAdminDashboard');
    }
}

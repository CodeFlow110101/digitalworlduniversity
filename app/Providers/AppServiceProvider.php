<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Policies\PostPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('is_Admin', function () {
            return (Role::find(Auth::user()->role_id)->name == 'admin');
        });

        Gate::define('is_Student', function () {
            return (Role::find(Auth::user()->role_id)->name == 'student');
        });
    }
}

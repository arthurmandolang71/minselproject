<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        //
        Paginator::useBootstrapFive();

        Gate::define('isAdmin', function (User $user) {
            return $user->level == 1;
        });

        Gate::define('isCaleg', function (User $user) {
            return $user->level == 2;
        });

        Gate::define('isTim', function (User $user) {
            return $user->level == 3;
        });

        Gate::define('profil', function () {
            return request()->segment(2) == request()->session()->get('user_id');
        });
    }
}

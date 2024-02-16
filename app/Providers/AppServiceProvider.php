<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $topUsers = Cache::remember('topUsers', 60 * 2, function(){
            return User::withCount('ideas')->orderBy('ideas_count', 'DESC')->take(10)->get();
        });

        View::share('topUsers', $topUsers);
    }
}

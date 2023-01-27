<?php

namespace App\Providers;

use App\Models\Channel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        // register variable to be available in all view, specify a view: threads.create   to make variable on create view only
        View::composer('*', function ($view) {
            $view->with('channels', Channel::all());
        });
        Paginator::useBootstrap();// fix paginator styles
    }
}

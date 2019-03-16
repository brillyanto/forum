<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Channel;

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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::share('channels', Channel::all());

        // Optional caching technique on loading channels variable for all views.
        // $channels = \Cache::rememberForever('channels', function(){
        //     return Channel::all();
        // });
        //
        // $view->with('channels', $channels);
        //
        
    }
}

<?php

namespace montserrat\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
         require app_path().'/constants.php';
    //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    public function boot(Charts $charts)
    {
        \Illuminate\Pagination\Paginator::useBootstrap();
        $charts->register([
            \App\Charts\Agc::class,
            \App\Charts\Board::class,
            \App\Charts\DonationDescription::class,
        ]);
    }
}

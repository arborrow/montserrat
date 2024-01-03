<?php

namespace App\Providers;

use App\Models\Contact;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

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
    public function boot(Charts $charts): void
    {
        \Illuminate\Pagination\Paginator::useBootstrap();
        Cashier::useCustomerModel(Contact::class);
    }
}

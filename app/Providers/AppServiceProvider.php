<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Permission;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

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
        \Illuminate\Pagination\Paginator::useBootstrap();
        Cashier::useCustomerModel(Contact::class);

        $this->bootAuth();
        $this->bootRoute();
    }

    public function bootAuth(): void
    {
        parent::registerPolicies();

        //prior to installing the app ignore checking for superuser or permissions to avoid artisan errors about missing permissions table
        if (config('app.key') !== null) {
            Gate::before(function ($user) {
                $superuser = \App\Models\Permission::where('name', 'superuser')->firstOrFail();

                // only return true if this user has a role with the superuser permission
                // otherwise
                if ($user->hasRole($superuser->roles)) {
                    return true;
                }
            });

            $permissions = Permission::with('roles')->get();
            foreach ($permissions as $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasRole($permission->roles);
                });
            }
        }
    }

    public function bootRoute(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}

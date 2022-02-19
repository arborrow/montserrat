<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Attachment::class => \App\Policies\AttachmentPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        parent::registerPolicies();

        //prior to installing the app ignore checking for superuser or permissions to avoid artisan errors about missing permissions table
        if (null !== config('app.key')) {
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
}

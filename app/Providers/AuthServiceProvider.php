<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Attachment::class => \App\Policies\AttachmentPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        parent::registerPolicies();

        Gate::before(function ($user) {
            $superuser = \App\Permission::where('name', 'superuser')->firstOrFail();

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

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
        'App\\Model' => 'App\\Policies\\ModelPolicy',
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
        if (null !== env('APP_KEY')) { //prior to installing the app ignore checking for superuser or permissions
            Gate::before(function ($user) {
                $superuser = \App\Permission::whereName('superuser')->firstOrFail();

                return $user->hasRole($superuser->roles);
            });

            foreach ($this->getPermissions() as $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasRole($permission->roles);
                });
            }
        }

        //
    }

    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}

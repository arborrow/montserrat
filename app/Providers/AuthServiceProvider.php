<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Attachment' => 'App\Policies\AttachmentPolicy',

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
            $superuser = \App\Permission::whereName('superuser')->firstOrFail();
            
            if ($user->hasRole($superuser->roles)) {
                return true;
            }
        });
        
        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }

        //
    }
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }

}

<?php

namespace montserrat\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use montserrat\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use montserrat\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'montserrat\Model' => 'montserrat\Policies\ModelPolicy',
        'montserrat\Attachment' => 'montserrat\Policies\AttachmentPolicy',

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
            $superuser = \montserrat\Permission::whereName('superuser')->firstOrFail();
            
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

<?php

namespace montserrat;

// use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;
use montserrat\Permission;

class Role extends EntrustRole
{
    //
    use SoftDeletes;
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions->save();
    }
}

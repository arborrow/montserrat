<?php

namespace montserrat;

// use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends EntrustPermission
{
    //
    use SoftDeletes;
    protected $table = 'permissions';
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function assignRoleTo(Role $role)
    {
        return $this->roles->save();
    }
}

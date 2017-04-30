<?php

namespace montserrat;

use Zizaco\Entrust\EntrustPermission;
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

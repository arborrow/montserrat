<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    //
    use SoftDeletes;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function assignRoleTo(Role $role)
    {
        return $this->roles->save();
    }
}

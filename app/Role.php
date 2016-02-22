<?php

namespace montserrat;

// use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EntrustRole
{
    //
    use SoftDeletes;
    
    public function users() {
        return $this->belongsToMany('\montserrat\User');
    }
    public function permissions() {
        return $this->belongsToMany('\montserrat\Permission');
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Retreatant extends Model
{
    use SoftDeletes; 

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];  //

    public function registrations() {
        return $this->hasMany('\App\Registration','id','retreat_id');
    }  //
}

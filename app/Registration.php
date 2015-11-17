<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    //
    protected $dates = ['start', 'end', 'register', 'confirmregister', 'confirmattend' ,'created_at', 'updated_at', 'disabled_at'];  //

    public function retreat()
    {
        return $this->belongsTo('App\Retreat','id','retreat_id');
    }
    public function retreatant()
    {
        return $this->belongsTo('App\Retreatant','retreatant_id','id');
    }
}

<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Registration extends Model
{   use SoftDeletes; 
    //
    protected $dates = ['start', 'end', 'register', 'confirmregister', 'confirmattend' ,'created_at', 'updated_at', 'disabled_at'];  //
   
    public function setRegisterAttribute($date) {
        if (strlen($date)) {
            $this->attributes['register'] = Carbon::parse($date);
        } else {
            $this->attributes['register'] = null;
        }
    }
    public function setConfirmattendAttribute($date) {
        if (strlen($date)) {
            $this->attributes['confirmattend'] = Carbon::parse($date);
        } else {
            $this->attributes['confirmattend'] = NULL;
            //dd($this->attributes['confirmattend']);
        }
    }
    public function setConfirmregisterAttribute($date) {
        if (strlen($date)) {
            $this->attributes['confirmregister'] = Carbon::parse($date);
        } else {
            $this->attributes['confirmregister'] = null;
        }
    }
    
    public function retreat()
    {
        return $this->belongsTo('montserrat\Retreat','retreat_id','id');
    }
    public function retreatant()
    {
        return $this->belongsTo('montserrat\Retreatant','retreatant_id','id');
    }
}

<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Registration extends Model
{   use SoftDeletes; 

    protected $table = 'participant';

    protected $dates = ['register_date', 'registration_confirm_date', 'attendance_confirm_date' ,'created_at', 'updated_at', 'disabled_at'];  //
   
    public function setRegisterDateAttribute($date) {
        if (strlen($date)) {
            $this->attributes['register_date'] = Carbon::parse($date);
        } else {
            $this->attributes['register_date'] = null;
        }
    }
    public function setAttendanceConfirmDateAttribute($date) {
        if (strlen($date)) {
            $this->attributes['attendance_confirm_date'] = Carbon::parse($date);
        } else {
            $this->attributes['attendance_confirm_date'] = NULL;
            //dd($this->attributes['confirmattend']);
        }
    }
    public function setRegistrationConfirmDateAttribute($date) {
        if (strlen($date)) {
            $this->attributes['registration_confirm_date'] = Carbon::parse($date);
        } else {
            $this->attributes['registration_confirm_date'] = null;
        }
    }
    public function setCanceledAtAttribute($date) {
        if (strlen($date)) {
            $this->attributes['canceled_at'] = Carbon::parse($date);
        } else {
            $this->attributes['canceled_at'] = null;
        }
    }
    public function setArrivedAtAttribute($date) {
        if (strlen($date)) {
            $this->attributes['arrived_at'] = Carbon::parse($date);
        } else {
            $this->attributes['arrived_at'] = null;
        }
    }
    public function setDepartedAtAttribute($date) {
        if (strlen($date)) {
            $this->attributes['departed_at'] = Carbon::parse($date);
        } else {
            $this->attributes['departed_at'] = null;
        }
    }
    
    public function retreat()
    {
        return $this->belongsTo('montserrat\Retreat','event_id','id');
    }
    public function retreatant()
    {
        return $this->belongsTo('montserrat\Contact','contact_id','id');
    }
    public function room()
    {
        return $this->hasOne('montserrat\Room','id','room_id');
    }
}
<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Reservation extends Model
{
    //
    use SoftDeletes; 
    protected $dates = ['start', 'end', 'register', 'confirmregister', 'confirmattend' ,'created_at', 'updated_at', 'disabled_at'];  //

    public function registration()
    {
        return $this->belongsTo('montserrat\Registration','registration_id','id');
    }
    public function room()
    {
        return $this->belongsTo('montserrat\Room','room_id','id');
    }

}

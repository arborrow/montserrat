<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Room extends Model
{
    //

   use SoftDeletes; 

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];  //

    public function location() {
        return $this->belongsTo('\montserrat\Location','building_id','id');
    }
    
    public function roomstates() {
        return $this->hasMany('\montserrat\Roomstate','room_id','id');
    }
        
}

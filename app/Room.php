<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    //

    use SoftDeletes;

    //

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function roomstates()
    {
        return $this->hasMany(Roomstate::class, 'room_id', 'id');
    }
}

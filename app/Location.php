<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Location extends Model
{
    //
     use SoftDeletes;

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_id', 'id');
    }
}

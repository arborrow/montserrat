<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    //
    use SoftDeletes;

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_id', 'id');
    }
}

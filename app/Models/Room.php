<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Room extends Model implements Auditable
{
    use HasFactory;

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function roomstates()
    {
        return $this->hasMany(Roomstate::class, 'room_id', 'id');
    }
}

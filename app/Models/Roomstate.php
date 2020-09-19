<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Roomstate extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $dates = [
        'statechange_at',
    ];  //

    //
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}

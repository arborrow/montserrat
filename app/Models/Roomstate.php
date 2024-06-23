<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Roomstate extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $casts = [
        'statechange_at' => 'datetime',
    ];  //

    //
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}

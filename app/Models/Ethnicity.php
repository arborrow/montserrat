<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Ethnicity extends Model implements Auditable
{
    use HasFactory;

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $dates = [
        'disabled_at',
    ];  //

    //
}

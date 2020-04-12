<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ethnicity extends Model
{
    use SoftDeletes;
    protected $dates = [
        'disabled_at',
    ];  //

    //
}

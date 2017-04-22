<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Ethnicity extends Model
{
    use SoftDeletes;
    protected $table = 'ethnicities';
    protected $dates = ['created_at', 'updated_at', 'disabled_at'];  //

    //
}

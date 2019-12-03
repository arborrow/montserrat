<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ethnicity extends Model
{
    use SoftDeletes;
    protected $table = 'ethnicities';
    protected $dates = ['created_at', 'updated_at', 'disabled_at'];  //

    //
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ethnicity extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at', 'disabled_at'];  //

    //
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Agc2019 extends Model
{
    protected $table = 'agc2018_clean';
    protected $dates = ['last_event', 'last_payment'];  //
    
}

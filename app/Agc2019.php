<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Agc2019 extends Model
{
    protected $table = 'agc_household_name';
    protected $dates = ['last_event', 'last_payment'];  //
    protected $primaryKey = 'contact_id';
    public $timestamps = false;
}

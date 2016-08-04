<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;
    protected $table = 'participant';
    protected $dates = ['register_date', 'registration_confirm_date', 'attendance_confirm_date', 'canceled_at', 'arrived_at','departed_at','updated_at', 'deleted_at']; 

}

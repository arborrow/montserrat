<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    //
    use SoftDeletes;
    protected $table = 'persons';
    protected $dates = ['dob', 'created_at', 'updated_at', 'deleted_at']; 
}

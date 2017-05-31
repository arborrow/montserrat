<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityStatus extends Model
{
    use SoftDeletes;
    protected $table = 'activity_status';
        
   
}

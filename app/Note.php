<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Note extends Model
{
    use SoftDeletes;
    protected $table = 'note';
    
}

<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Diocese extends Model
{   use SoftDeletes; 
    //
    public function parishes() {
        return $this->hasMany('\montserrat\Parish','diocese_id','id');
    }
    public function bishops() {
        return $this->hasMany('\montserrat\Contact','id','bishop_id');
    }
}

<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parish extends Model
{
     use SoftDeletes;
    protected $table = 'parishes';

    //
    public function diocese() {
        return $this->belongsTo('\montserrat\Diocese','diocese_id','id');
    }
    
    //
    public function parishioners() {
        return $this->hasMany('\montserrat\Person','parish_id','id');
    }
}

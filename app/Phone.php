<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    
class Phone extends Model
{
    //
    use SoftDeletes;
    protected $table = 'phone';
    
    public function owner() {
        return $this->belongsTo('\montserrat\Person','contact_id','id');
    }
    
    public function location() {
        return $this->belongsTo('\montserrat\LocationType','location_type_id','id');
    }
    
}

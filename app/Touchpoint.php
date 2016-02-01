<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Touchpoint extends Model
{
    //
    use SoftDeletes;
    protected $table = 'touchpoints';
    protected $dates = ['touched_at', 'created_at', 'updated_at', 'deleted_at']; 
    
    public function person() {
        return $this->belongsTo('\montserrat\Person','person_id','id');
    }
    
    public function staff() {
        return $this->belongsTo('\montserrat\Person','staff_id','id');
    }
    
}

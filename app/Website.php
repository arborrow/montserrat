<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Website extends Model
{
    //
    use SoftDeletes;
    protected $table = 'website';
    
    public function owner() {
        return $this->belongsTo('\montserrat\Person','contact_id','id');
    }
    
}

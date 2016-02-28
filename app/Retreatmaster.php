<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retreatmaster extends Model
{
    //
    use SoftDeletes;
    
    protected $table = 'retreatmasters';
    protected $fillable = ['retreat_id', 'retreatmaster_id'];
    
    public function retreat() {
        return $this->belongsTo('\montserrat\Retreat','retreat_id','id');
    }
        
    public function retreatmaster() {
        return $this->belongsTo('\montserrat\Person','retreatmaster_id','id');
    }

}

<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retreat extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    use SoftDeletes;
    
    protected $table = 'retreats';

    protected $dates = ['start', 'end', 'created_at', 'updated_at', 'disabled_at', 'deleted_at'];  //
    
    public function setStartAttribute($date) {
      $this->attributes['start'] = Carbon::parse($date);
    }
    
    public function setEndAttribute($date) {
      $this->attributes['end'] = Carbon::parse($date);
    }
  
    public function assistant() {
        return $this->belongsTo('\montserrat\Person','assistantid','id');
    }
    
    public function director() {
        return $this->belongsTo('\montserrat\Person','directorid','id');
    }
    
    public function innkeeper() {
        return $this->belongsTo('\montserrat\Person','innkeeperid','id');
    }
    
    public function retreatmasters() {
        return $this->hasMany('\montserrat\Retreatmaster','retreat_id','id');
    }
    
    public function registrations() {
        return $this->hasMany('\montserrat\Registration','retreat_id','id');
    }
    
}

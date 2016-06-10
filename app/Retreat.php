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
        return $this->belongsTo('\montserrat\Contact','assistantid','id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    
    public function innkeeper() {
        return $this->belongsTo('\montserrat\Contact','innkeeperid','id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    
    public function retreatmasters() {
        return $this->belongsToMany('\montserrat\Contact','retreatmasters','retreat_id','person_id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    
    public function registrations() {
        return $this->hasMany('\montserrat\Registration','retreat_id','id');
    }

    public function getEmailRegisteredRetreatantsAttribute () {
        $bcc_list = '';
        foreach ($this->registrations as $registration) {
            if (!empty($registration->retreatant->email_primary_text)) {
                $bcc_list .= $registration->retreatant->email_primary_text.',';
            }
        }
        return "<a href='mailto:?bcc=".$bcc_list."'>E-mail Registered Retreatants</a>";
    }

}

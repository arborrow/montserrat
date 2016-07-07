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
    
    protected $table = 'event';

    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at', 'disabled_at', 'deleted_at'];  //
    
    public function setStartAttribute($date) {
      $this->attributes['start_date'] = Carbon::parse($date);
    }
    
    public function setEndAttribute($date) {
      $this->attributes['end_date'] = Carbon::parse($date);
    }
    
    public function getRegistrationCountAttribute() {
        return $this->registrations->count();
    }
  
    public function assistant() {
        return $this->belongsTo('\montserrat\Contact','assistant_id','id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    
    public function innkeeper() {
        return $this->belongsTo('\montserrat\Contact','innkeeper_id','id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    
    public function retreatmasters() {
        // TODO: handle with participants of role Retreat Director or Master - be careful with difference between (registration table) retreat_id and (participant table) event_id
        return $this->belongsToMany('\montserrat\Contact','retreatmasters','retreat_id','person_id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    
    public function registrations() {
        return $this->hasMany('\montserrat\Registration','event_id','id');
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
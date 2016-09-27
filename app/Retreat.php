<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Html; 
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
    
    public function setStartDateAttribute($date) {
      $this->attributes['start_date'] = Carbon::parse($date);
    }
    
    public function setEndDateAttribute($date) {
      $this->attributes['end_date'] = Carbon::parse($date);
    }
    
    public function getRegistrationCountAttribute() {
        // keep in mind that if/when innkeeper and other not retreatant roles are added will not to use where clause to keep the count accurate and exclude non-participating participants
        return $this->registrations->count();
    }

    public function getRetreatantCountAttribute() {
        // keep in mind that if/when innkeeper and other not retreatant roles are added will not to use where clause to keep the count accurate and exclude non-participating participants
        return $this->retreatants->count();
    }

    public function assistant() {
        return $this->belongsTo('\montserrat\Contact','assistant_id','id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    public function captains() {
        // TODO: handle with participants of role Retreat Director or Master - be careful with difference between (registration table) retreat_id and (participant table) event_id
        return $this->belongsToMany('\montserrat\Contact','captain_retreat','event_id','contact_id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    
    public function innkeeper() {
        return $this->belongsTo('\montserrat\Contact','innkeeper_id','id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    public function event_type() {
        return $this->hasOne('\montserrat\EventType','id','event_type_id');
    }
    
    public function retreatmasters() {
        // TODO: handle with participants of role Retreat Director or Master - be careful with difference between (registration table) retreat_id and (participant table) event_id
        return $this->belongsToMany('\montserrat\Contact','retreatmasters','retreat_id','person_id')->whereContactType(CONTACT_TYPE_INDIVIDUAL);
    }
    
    public function registrations() {
        return $this->hasMany('\montserrat\Registration','event_id','id');
    }

    public function retreatants() {
        return $this->registrations()->whereCanceledAt(NULL);
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
    public function getRetreatTypeAttribute () {
        //dd($this->event_type);
        if (isset($this->event_type)) {
            return $this->event_type->name;
        } else 
            return NULL;
        }
    public function getRetreatScheduleLinkAttribute () {
        if (Storage::has('events/'.$this->id.'/schedule.pdf')) {
            $img = Html::image('img/schedule.png', 'Schedule',array('title'=>"Schedule"));
            $link = '<a href="'.url('retreat/'.$this->id.'/schedule" ').'class="btn btn-default" style="padding: 3px;">'.$img.'</a>';
            return $link;
        } else {
            return NULL;
        }
    }
    
    public function getRetreatContractLinkAttribute () {
        if (Storage::has('events/'.$this->id.'/contract.pdf')) {
            $img = Html::image('img/contract.png', 'Contract',array('title'=>"Contract"));
            $link = '<a href="'.url('retreat/'.$this->id.'/contract" ').'class="btn btn-default" style="padding: 3px;">'.$img.'</a>';
            return $link;
        } else {
            return NULL;
        }
    }
    
    public function getRetreatEvaluationsLinkAttribute () {
        if (Storage::has('events/'.$this->id.'/evaluations.pdf')) {
            $img = Html::image('img/evaluation.png', 'Evaluations',array('title'=>"Evaluations"));
            $link = '<a href="'.url('retreat/'.$this->id.'/evaluations" ').'class="btn btn-default" style="padding: 3px;">'.$img.'</a>';
            return $link;
        } else {
            return NULL;
        }
    }
}
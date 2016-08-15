<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;
    protected $table = 'participant';
    protected $dates = ['register_date', 'registration_confirm_date', 'attendance_confirm_date', 'canceled_at', 'arrived_at','departed_at','updated_at', 'deleted_at']; 

    public function event() {
        return $this->hasOne('\montserrat\Retreat','id','event_id'); 
    }
    public function contact() {
        return $this->hasOne('\montserrat\Contact','id','contact_id'); 
    }
    public function getEventLinkAttribute () {
        if (!empty($this->event)) {
            $path=url('retreat/'.$this->event->id);
            return '<a href="'.$path.'">'.$this->event->title.'</a>';
        } else {
            return NULL;
        }
    }

}

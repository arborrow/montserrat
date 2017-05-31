<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityContact extends Model
{
    use SoftDeletes;
        protected $table = 'activity_contact';
        
    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');
    }
    public function contact()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }
    
    public function getDetailsAttribute() {
        return $this->activity->details;
    }
    public function getTouchedAtAttribute() {
        return $this->activity->activity_date_time;
    }

}

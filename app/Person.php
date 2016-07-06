<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    //
    use SoftDeletes;
    protected $table = 'persons';
    protected $dates = ['birth_date', 'deceased_date', 'created_at', 'updated_at', 'deleted_at']; 
    
    public function setBirthDateAttribute($date) {
        if (strlen($date)) {
            $this->attributes['birth_date'] = Carbon::parse($date);
        } else {
            $this->attributes['birth_date'] = null;
        }
    }
    
    public function parish() {
        return $this->belongsTo('\montserrat\Parish','parish_id','id');
    }
    
    public function touchpoints() {
        return $this->hasMany('\montserrat\Touchpoint','person_id','id');
    }
    
    public function retreatmasters() {
        // TODO: move all of the roles to participants - for now be careful with differenc between retreat_id and event_id
        return $this->belongsToMany('\montserrat\Retreat','retreatmasters','person_id','retreat_id');
    }
    
    public function websites() {
        return $this->hasMany('\montserrat\Website','contact_id','id');
    }

    public function addresses() {
        return $this->hasMany('\montserrat\Address','contact_id','id');
    }
    
    public function phones() {
        return $this->hasMany('\montserrat\Phone','contact_id','id');
    }
    
    public function emails() {
        return $this->hasMany('\montserrat\Email','contact_id','id');
    }

    public function prefix() {
        return $this->hasOne('\montserrat\Prefix','prefix_id','prefix_id');
    }
    
    public function suffix() {
        return $this->hasOne('\montserrat\Suffix','suffix_id','id');
    }

        
}

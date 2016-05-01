<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Contact extends Model
{
    use SoftDeletes; 
    protected $table = 'contact';
    protected $dates = ['birth_date', 'deceased_date', 'created_date','modified_date', 'created_at', 'updated_at', 'deleted_at']; 
    
    // TODO: refactor to lookup based on relationship
    //TODO: rename person_id to contact_id
/*    public function retreatmasters() {
        return $this->belongsToMany('\montserrat\Retreat','retreatmasters','person_id','retreat_id');
    }
*/
    public function setBirthDateAttribute($date) {
        if (strlen($date)) {
            $this->attributes['birth_date'] = Carbon::parse($date);
        } else {
            $this->attributes['birth_date'] = null;
        }
    }
    public function a_relationships() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id');
    }
    
    public function b_relationships() {
        return $this->hasMany('\montserrat\Relationship','contact_id_b','id');
    }

    public function addresses() {
        return $this->hasMany('\montserrat\Address','contact_id','id');
    }
    
    public function address_primary() {
        return $this->hasOne('\montserrat\Address','contact_id','id')->whereIsPrimary(1);
    }
    
    public function bishops() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_BISHOP);
    }
    
    public function diocese() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_DIOCESE);
    }
        
    public function emails() {
        return $this->hasMany('\montserrat\Email','contact_id','id');
    }
    
    public function email_primary() {
        return $this->hasOne('\montserrat\Email','contact_id','id')->whereIsPrimary(1);
    }
    
    public function emergency_contact() {
        return $this->hasOne('\montserrat\EmergencyContact','contact_id','id');
    }
    
    public function ethnicity() {
        return $this->hasOne('\montserrat\Ethnicity','id','ethnicity_id');
    }
    
    public function gender() {
        return $this->hasOne('\montserrat\Gender','id','gender_id');
    }
    
    public function groups() {
        return $this->hasMany('\montserrat\GroupContact','contact_id','id');
    }

    public function languages() {
        return $this->belongsToMany('\montserrat\Language','contact_languages','contact_id','language_id');
    }

    
    public function notes() {
        return $this->hasMany('\montserrat\Note','entity_id','id')->whereEntityTable('contact');
    }
    
    public function occupation() {
        return $this->hasOne('\montserrat\Ppd_occupation','id','occupation_id');
    }
    
    public function phones() {
        return $this->hasMany('\montserrat\Phone','contact_id','id');
    }
    
    public function phone_primary() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->whereIsPrimary(1);
    }
    public function phone_main_fax() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Fax')->whereLocationTypeId(3);
    }
    
    public function parish() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_PARISHIONER);
    }
    
    public function parishes() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_DIOCESE);
    }
    
    public function parishioners() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_PARISHIONER);
    }
    
    public function pastor() {
        return $this->hasOne('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_PASTOR);
    }
    
    public function prefix() {
        return $this->hasOne('\montserrat\Prefix','id','prefix_id');
    }
    
    public function religion() {
        return $this->hasOne('\montserrat\Religion','id','religion_id');
    }
    
    public function retreat_assistants() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_RETREAT_ASSISTANT)->whereIsActive(1);
    }
    
    public function retreat_directors() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_RETREAT_DIRECTOR);
    }
    
    public function retreat_innkeepers() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_RETREAT_INNKEEPER);
    }
    
    public function suffix() {
        return $this->hasOne('\montserrat\Suffix','id','suffix_id');
    }
    
    public function touchpoints() {
        return $this->hasMany('\montserrat\Touchpoint','person_id','id');
    }
    
    public function websites() {
        return $this->hasMany('\montserrat\Website','contact_id','id');
    }
    public function website_main() {
        return $this->hasOne('\montserrat\Website','contact_id','id')->whereWebsiteType('Main');
    }

    
}

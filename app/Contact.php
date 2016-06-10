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
    
    public function getAddressPrimaryStreetAttribute() {
        if (isset($this->address_primary->street_address)) {
            if (isset($this->address_primary->supplemental_address)) {
                return $this->address_primary->street_address.' '.$this->address_primary->supplemental_address;
            } else {
                return $this->address_primary->street_address;
            }
        } else {
            return NULL;
        }
    }  
    
    public function getAddressPrimaryCityAttribute() {
        if (isset($this->address_primary->city)) {
            return $this->address_primary->city;
        } else {
            return NULL;
        }
    }  
    public function getAddressPrimaryStateAttribute() {
        if (isset($this->address_primary->state->abbreviation)) {
            return $this->address_primary->state->abbreviation;
        } else {
            return NULL;
        }
    }  
    public function getAddressPrimaryPostalCodeAttribute() {
        if (isset($this->address_primary->postal_code)) {
            return $this->address_primary->postal_code;
        } else {
            return NULL;
        }
    }  
    
    public function getPrefixNameAttribute () {
        if (isset($this->prefix_id)&&($this->prefix_id>0)) {
            return $this->prefix->name;
        } else {
            return NULL;
        }
    }
    
    public function getSuffixNameAttribute () {
        if (isset($this->suffix_id)&&($this->suffix_id>0)) {
            return $this->suffix->name;
        } else {
            return NULL;
        }
    }
    public function getEmailPrimaryTextAttribute () {
        if (isset($this->email_primary->email)&&($this->ethnicity_id>0)) {
            return $this->email_primary->email;
        } else {
            return NULL;
        }
    }

    public function getEthnicityNameAttribute () {
        if (isset($this->ethnicity_id)&&($this->ethnicity_id>0)) {
            return $this->ethnicity->ethnicity;
        } else {
            return NULL;
        }
    }

    public function getGenderNameAttribute () {
        if (isset($this->gender_id)&&($this->gender_id>0)) {
            return $this->gender->name;
        } else {
            return NULL;
        }
    }

    public function getParishNameAttribute () {
        if (isset($this->parish->contact_id_a)&&($this->parish->contact_id_a>0)) {
           
            return $this->parish->contact_a->display_name.' ('.$this->parish->contact_a->address_primary->city.')';
        } else {
            
            return NULL;
        }
    }

    public function getPhoneHomeMobileNumberAttribute () {
        if (isset($this->phone_home_mobile->phone)) {
            return $this->phone_home_mobile->phone;
        } else {
            return NULL;
        }
    }
    public function getPhoneHomePhoneNumberAttribute () {
        if (isset($this->phone_home_phone->phone)) {
            return $this->phone_home_phone->phone;
        } else {
            return NULL;
        }
    }
    
    public function getPhoneWorkPhoneNumberAttribute () {
        if (isset($this->phone_work_phone)) {
            return $this->phone_work_phone->phone;
        } else {
            return NULL;
        }
    }
    
    public function getNoteDietaryTextAttribute () {
        if (isset($this->note_dietary->note)) {
            return $this->note_dietary->note; 
        } else {
            return NULL;
        }
    }
    public function getNoteHealthTextAttribute () {
        if (isset($this->note_health->note)) {
            return $this->note_health->note;
        } else {
            return NULL;
        }
    }
    public function getNoteGeneralTextAttribute () {
        if (isset($this->note_general->note)) {
            return $this->note_general->note;
        } else {
            return NULL;
        }
    }
    public function getNoteRegistrationTextAttribute () {
        if (isset($this->note_registration->note)) {
            return $this->note_registration->note;
        } else {
            return NULL;
        }
    }
    public function getNoteRoomPreferenceTextAttribute () {
        if (isset($this->note_room_preference->note)) {
            return $this->note_room_preference->note;
        } else {
            return NULL;
        }
    }
    public function getOccupationNameAttribute () {
        if (isset($this->occupation_id)&&($this->occupation_id>0)) {
            return $this->occupation->name;
        } else {
            return NULL;
        }
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
    public function note_dietary() {
        return $this->hasOne('\montserrat\Note','entity_id','id')->whereEntityTable('contact')->whereSubject('Dietary Note'); 
    }
    public function note_health() {
        return $this->hasOne('\montserrat\Note','entity_id','id')->whereEntityTable('contact')->whereSubject('Health Note'); 
    }
    public function note_room_preference() {
        return $this->hasOne('\montserrat\Note','entity_id','id')->whereEntityTable('contact')->whereSubject('Room Preference'); 
    }
    public function note_general() {
        return $this->hasOne('\montserrat\Note','entity_id','id')->whereEntityTable('contact')->whereSubject('Contact Note'); 
    }
    public function note_registration() {
        return $this->hasOne('\montserrat\Note','entity_id','id')->whereEntityTable('contact')->whereSubject('Registration Note'); 
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
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Fax')->whereLocationTypeId(LOCATION_TYPE_MAIN); 
    }
    public function phone_home_phone() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Phone')->whereLocationTypeId(LOCATION_TYPE_HOME); 
    }
    public function phone_home_mobile() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Mobile')->whereLocationTypeId(LOCATION_TYPE_HOME); 
    }
    public function phone_home_fax() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Fax')->whereLocationTypeId(LOCATION_TYPE_HOME); 
    }
    public function phone_work_phone() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Phone')->whereLocationTypeId(LOCATION_TYPE_WORK); 
    }
    public function phone_work_mobile() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Mobile')->whereLocationTypeId(LOCATION_TYPE_WORK); 
    }
    public function phone_work_fax() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Fax')->whereLocationTypeId(LOCATION_TYPE_WORK); 
    }
    public function phone_other_phone() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Phone')->whereLocationTypeId(LOCATION_TYPE_OTHER); 
    }
    public function phone_other_mobile() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Mobile')->whereLocationTypeId(LOCATION_TYPE_OTHER); 
    }
    public function phone_other_fax() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Fax')->whereLocationTypeId(LOCATION_TYPE_OTHER); 
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

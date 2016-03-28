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
    
    // TODO: rename person_id to contact_id
    public function touchpoints() {
        return $this->hasMany('\montserrat\Touchpoint','person_id','id');
    }
    
    //TODO: rename person_id to contact_id
/*    public function retreatmasters() {
        return $this->belongsToMany('\montserrat\Retreat','retreatmasters','person_id','retreat_id');
    }
*/
    
    
    
    public function a_relationships() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id');
    }
    
    public function b_relationships() {
        return $this->hasMany('\montserrat\Relationship','contact_id_b','id');
    }
    
    public function websites() {
        return $this->hasMany('\montserrat\Website','contact_id','id');
    }
    public function website_main() {
        return $this->hasOne('\montserrat\Website','contact_id','id')->whereWebsiteType('Main');
    }

    public function addresses() {
        return $this->hasMany('\montserrat\Address','contact_id','id');
    }
    
    public function primary_address() {
        return $this->hasOne('\montserrat\Address','contact_id','id')->whereIsPrimary(1);
    }
    
    public function phones() {
        return $this->hasMany('\montserrat\Phone','contact_id','id');
    }
    
    public function primary_phone() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->whereIsPrimary(1);
    }
    public function phone_main_fax() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Fax')->whereLocationTypeId(3);
    }
    
    public function emails() {
        return $this->hasMany('\montserrat\Email','contact_id','id');
    }
    
    public function groups() {
        return $this->hasMany('\montserrat\GroupContact','contact_id','id');
    }
    
    public function primary_email() {
        return $this->hasOne('\montserrat\Email','contact_id','id')->whereIsPrimary(1);
    }
    
    public function notes() {
        return $this->hasMany('\montserrat\Note','entity_id','id')->whereEntityTable('contact');
    }
    public function pastor() {
        return $this->hasOne('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_PASTOR);
    }
    public function parishioners() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_PARISHIONER);
    }
    public function bishops() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_BISHOP);
    }
    public function parishes() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_DIOCESE);
    }
    public function dallas_parishes() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_DIOCESE)->whereContactIdA(CONTACT_DIOCESE_DALLAS);
    }
  
    public function diocese() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_DIOCESE);
    }
    
    public function parish() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_PARISHIONER);
    }
    
    public function getContactFullNameAttribute()
    {
        return $this->attributes['last_name'] .', '. $this->attributes['first_name'];
    }
}

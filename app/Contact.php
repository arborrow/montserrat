<?php

namespace montserrat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Response;

class Contact extends Model
{
    use SoftDeletes; 
    protected $table = 'contact';
    protected $dates = ['birth_date', 'deceased_date', 'created_date','modified_date', 'created_at', 'updated_at', 'deleted_at']; 
    protected $casts = [
        'contact_type' => 'integer',
        'subcontact_type' => 'integer',
    ]; 
    // TODO: refactor to lookup based on relationship
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
    public function addresses() {
        return $this->hasMany('\montserrat\Address','contact_id','id');
    }
    public function address_primary() {
        return $this->hasOne('\montserrat\Address','contact_id','id')->whereIsPrimary(1);
    }
    public function bishops() {
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_BISHOP);
    }
    public function contacttype() {
        return $this->hasOne('\montserrat\ContactType','id','contact_type');
    }
    public function subcontacttype() {
        return $this->hasOne('\montserrat\ContactType','id','subcontact_type');
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
    public function getAddressPrimaryGoogleMapAttribute() {
        if (isset($this->address_primary->google_map)) {
            return $this->address_primary->google_map;
        } else {
            return NULL;
        }
    }
    /* Not currently working as expected so I am commenting this out for now
    public function getAvatarLinkAttribute() {
        $path = storage_path() . '/app/contacts/' . $this->id . '/avatar.png';
        //dd($path);
        if(!File::exists($path)) {
            return NULL;
        } else {
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
    
    }
     * 
     */
    public function getContactLinkAttribute() {
        
        switch ($this->subcontact_type) {
            case CONTACT_TYPE_PARISH : $path = url("parish/".$this->id); break;
            case CONTACT_TYPE_DIOCESE: $path = url("diocese/".$this->id); break;
            case CONTACT_TYPE_VENDOR : $path = url("vendor/".$this->id); break;
            default : $path = url("organization/".$this->id);
        }
        
        if ($this->contact_type == CONTACT_TYPE_INDIVIDUAL) {
            $path=url("person/".$this->id);
        }
        
        return "<a href='".$path."'>".$this->display_name."</a>";
    }
    
public function getContactLinkFullNameAttribute() {
        switch ($this->subcontact_type) {
            case CONTACT_TYPE_PARISH : $path = url("parish/".$this->id); break;
            case CONTACT_TYPE_DIOCESE: $path = url("diocese/".$this->id); break;
            case CONTACT_TYPE_VENDOR : $path = url("vendor/".$this->id); break;
            default : $path = url("organization/".$this->id);
        }
        if ($this->contact_type == CONTACT_TYPE_INDIVIDUAL) {
            $path=url("person/".$this->id);
        }
        
        return "<a href='".$path."'>".$this->full_name."</a>";
            
    }

    public function getContactTypeLabelAttribute() {
        
        if (isset($this->contacttype->label)) {
            return $this->contacttype->label;
        } else {
            return 'N/A';
        }
    }  
    public function getSubcontactTypeLabelAttribute() {
        
        if (isset($this->subcontacttype->label)) {
            return $this->subcontacttype->label;
        } else {
            return 'N/A';
        }
    }  
    public function getDioceseIdAttribute() {
        if (isset($this->diocese->contact_id_a)) {
            return $this->diocese->contact_id_a;
        } else {
            return NULL;
        }
    }
    public function getDioceseNameAttribute() {
        if (isset($this->diocese->contact_a->organization_name)) {
            return $this->diocese->contact_a->organization_name;
        } else {
            return NULL;
        }
    }
    public function getEmailPrimaryTextAttribute () {
        if (!empty($this->email_primary->email)) {
            return $this->email_primary->email;
        } else {
            return NULL;
        }
    }
    public function getEmergencyContactNameAttribute () {
        if (!empty($this->emergency_contact->name)) {
            return $this->emergency_contact->name;
        } else {
            return NULL;
        }
    }
    public function getEmergencyContactRelationshipAttribute () {
        if (!empty($this->emergency_contact->relationship)) {
            return $this->emergency_contact->relationship;
        } else {
            return NULL;
        }
    }
    public function getEmergencyContactPhoneAttribute () {
        if (!empty($this->emergency_contact->phone)) {
            return $this->emergency_contact->phone;
        } else {
            return NULL;
        }
    }
    public function getEmergencyContactPhoneAlternateAttribute () {
        if (!empty($this->emergency_contact->phone_alternate)) {
            return $this->emergency_contact->phone_alternate;
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
    public function getFullNameAttribute () {
        if ($this->contact_type == CONTACT_TYPE_INDIVIDUAL)
        {
            $full_name = '';
            if (isset($this->prefix->name)) {
                $full_name .= $this->prefix->name. ' ';
            }

            if (isset($this->first_name)) {
                $full_name .= $this->first_name. ' ';
            }
            if (isset($this->nick_name)) {
                $full_name .= '"'.$this->nick_name.'" ';
            }
            if (isset($this->middle_name)) {
                $full_name .= $this->middle_name.' ';
            }
            if (isset($this->last_name)) {
                $full_name .= $this->last_name;
            }
            if (isset($this->suffix->name)) {
                $full_name .= ', '.$this->suffix->name;
            }
        }
        if ($this->contact_type == CONTACT_TYPE_ORGANIZATION)
        {
            $full_name = $this->organization_name;
        }
        
            return $full_name;
    }
    public function getGenderNameAttribute () {
        if (isset($this->gender_id)&&($this->gender_id>0)) {
            return $this->gender->name;
        } else {
            return NULL;
        }
    }
    public function getIsDonorAttribute () {
        if (!empty($this->relationship_mjrh_donor->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsRetreatantAttribute () {
        if (!empty($this->relationship_mjrh_retreatant->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsCaptainAttribute () {
        if (isset($this->group_captain->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsVolunteerAttribute () {
        if (isset($this->group_volunteer->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsBishopAttribute () {
        if (isset($this->group_bishop->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsPriestAttribute () {
        if (isset($this->group_priest->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsDeaconAttribute () {
        if (isset($this->group_deacon->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsPastorAttribute () {
        if (isset($this->group_pastor->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsJesuitAttribute () {
        if (isset($this->group_jesuit->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsProvincialAttribute () {
        if (isset($this->group_provincial->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsSuperiorAttribute () {
        if (isset($this->group_superior->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsBoardMemberAttribute () {
        if (isset($this->group_board_member->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsStaffAttribute () {
        if (isset($this->group_staff->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsRetreatDirectorAttribute () {
        if (isset($this->relationship_mjrh_retreat_director->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsRetreatInnkeeperAttribute () {
        if (isset($this->relationship_mjrh_retreat_innkeeper->id)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getIsRetreatAssistantAttribute () {
        if (isset($this->relationship_mjrh_retreat_assistant->id)) {
            return TRUE;
        } else {
            return FALSE;
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
    public function getNoteOrganizationTextAttribute () {
        if (isset($this->note_organization->note)) {
            return $this->note_organization->note;
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
    public function getParishNameAttribute () {
        if (isset($this->parish->contact_id_a)&&($this->parish->contact_id_a>0)) {
           
            return $this->parish->contact_a->display_name.' ('.$this->parish->contact_a->address_primary->city.')';
        } else {
            
            return NULL;
        }
    }
    public function getParishLinkAttribute () {
        if (isset($this->parish->contact_id_a)&&($this->parish->contact_id_a>0)) {
           $path = url('parish/'.$this->parish->contact_a->id);
            return "<a href='".$path."'>".$this->parish->contact_a->display_name.' ('.$this->parish->contact_a->address_primary->city.')'."</a>";
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
    public function getPhoneMainPhoneNumberAttribute () {
        if (isset($this->phone_main_phone)) {
            return $this->phone_main_phone->phone;
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
    public function gender() {
        return $this->hasOne('\montserrat\Gender','id','gender_id');
    }
    public function group_captain() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_CAPTAIN);
    }
    public function group_volunteer() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_VOLUNTEER);
    }
    public function group_bishop() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_BISHOP);
    }
    public function group_priest() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_PRIEST);
    }
    public function group_deacon() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_DEACON);
    }
    public function group_pastor() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_PASTOR);
    }
    public function group_jesuit() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_JESUIT);
    }
    public function group_provincial() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_PROVINCIAL);
    }
    public function group_superior() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_SUPERIOR);
    }
    public function group_board_member() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_BOARD);
    }
    public function group_staff() {
        return $this->hasOne('\montserrat\GroupContact','contact_id','id')->whereGroupId(GROUP_ID_STAFF);
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
    public function note_organization() {
        return $this->hasOne('\montserrat\Note','entity_id','id')->whereEntityTable('contact')->whereSubject('Organization Note'); 
    }
    public function note_registration() {
        return $this->hasOne('\montserrat\Note','entity_id','id')->whereEntityTable('contact')->whereSubject('Registration Note'); 
    }
    public function occupation() {
        return $this->hasOne('\montserrat\Ppd_occupation','id','occupation_id');
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
    public function phones() {
        return $this->hasMany('\montserrat\Phone','contact_id','id');
    }
    public function phone_primary() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->whereIsPrimary(1);
    }
    public function phone_main_phone() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Phone')->whereLocationTypeId(LOCATION_TYPE_MAIN); 
    }
    public function phone_main_mobile() {
        return $this->hasOne('\montserrat\Phone','contact_id','id')->wherePhoneType('Mobile')->whereLocationTypeId(LOCATION_TYPE_MAIN); 
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
    public function prefix() {
        return $this->hasOne('\montserrat\Prefix','id','prefix_id');
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
    public function retreat_captains() {
        // TODO: handle with participants of role Retreat Director or Master - be careful with difference between (registration table) retreat_id and (participant table) event_id
        return $this->hasMany('\montserrat\Relationship','contact_id_a','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_CAPTAIN);
    }
    public function event_registrations() {
        // the events (retreats) for which this contact has been a retreatant  
        return $this->hasMany('\montserrat\Participant','contact_id','id');
    }
    public function event_captains() {
        // the events (retreats) for which this contact has been a retreatant  
        return $this->hasMany('\montserrat\Participant','contact_id','id')->whereRoleId(PARTICIPANT_ROLE_ID_CAPTAIN);
    }
    public function event_retreatants() {
        // the events (retreats) for which this contact has been a retreatant  
        return $this->hasMany('\montserrat\Participant','contact_id','id')->whereRoleId(PARTICIPANT_ROLE_ID_RETREATANT);
    }
    public function relationship_mjrh_donor() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_DONOR);
    }   
    public function relationship_mjrh_retreatant() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_RETREATANT)->whereIsActive(1)->whereContactIdA(CONTACT_MONTSERRAT);
    }
    public function relationship_mjrh_retreat_assistant() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_RETREAT_ASSISTANT)->whereContactIdA(CONTACT_MONTSERRAT)->whereIsActive(1);
    }
    public function relationship_mjrh_retreat_director() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_RETREAT_DIRECTOR)->whereContactIdA(CONTACT_MONTSERRAT)->whereIsActive(1);
    }
    public function relationship_mjrh_retreat_innkeeper() {
        return $this->hasOne('\montserrat\Relationship','contact_id_b','id')->whereRelationshipTypeId(RELATIONSHIP_TYPE_RETREAT_INNKEEPER)->whereContactIdA(CONTACT_MONTSERRAT)->whereIsActive(1);
    }
    public function religion() {
        return $this->hasOne('\montserrat\Religion','id','religion_id');
    }
    public function setBirthDateAttribute($date) {
        if (strlen($date)) {
            $this->attributes['birth_date'] = Carbon::parse($date);
        } else {
            $this->attributes['birth_date'] = null;
        }
    }
    public function setNickNameAttribute($nick_name)
    {
        $this->attributes['nick_name'] = trim($nick_name) !== '' ? $nick_name : null;
    }
    public function setMiddleNameAttribute($middle_name)
    {
        $this->attributes['middle_name'] = trim($middle_name) !== '' ? $middle_name : null;
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
    public function scopeOrganizations_Generic($query) {
        return $query->where([
            ['contact_type','>=',CONTACT_TYPE_ORGANIZATION],
            ['subcontact_type','>=',CONTACT_TYPE_PROVINCE],
            ]);
    }
}
<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\File;
use Response;

class PersonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-contact');
        $persons = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name', 'asc')->with('addresses.state', 'phones', 'emails', 'websites', 'parish.contact_a')->paginate(100);
       
        return view('persons.index', compact('persons'));   //
    }

    public function lastnames($lastname = null)
    {
       
        $persons = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name', 'asc')->with('addresses.state', 'phones', 'emails', 'websites', 'parish.contact_a')->where('last_name', 'LIKE', $lastname.'%')->paginate(100);
       //dd($persons);
        return view('persons.index', compact('persons'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-contact');
        $parishes = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PARISH)->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        $parish_list[0]='N/A';
        // while probably not the most efficient way of doing this it gets me the result
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }

        $countries = \montserrat\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);
        $ethnicities = \montserrat\Ethnicity::orderBy('ethnicity')->pluck('ethnicity', 'id');
        $ethnicities->prepend('N/A', 0);
        $genders = \montserrat\Gender::orderBy('name')->pluck('name', 'id');
        $genders ->prepend('N/A', 0);
        $languages = \montserrat\Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('N/A', 0);
        $referrals = \montserrat\Referral::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $referrals->prepend('N/A', 0);
        $prefixes= \montserrat\Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('N/A', 0);
        $religions = \montserrat\Religion::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $religions->prepend('N/A', 0);
        $states = \montserrat\StateProvince::orderBy('name')->whereCountryId(1228)->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $suffixes = \montserrat\Suffix::orderBy('name')->pluck('name', 'id');
        $suffixes->prepend('N/A', 0);
        $occupations = \montserrat\Ppd_occupation::orderBy('name')->pluck('name', 'id');
        $occupations->prepend('N/A', 0);
        $contact_types = \montserrat\ContactType::whereIsReserved(true)->orderBy('label')->pluck('label', 'id');
        $subcontact_types = \montserrat\ContactType::whereIsReserved(false)->whereIsActive(true)->orderBy('label')->pluck('label', 'id');
        $subcontact_types->prepend('N/A', 0);
        
        //dd($subcontact_types);
        return view('persons.create', compact('parish_list', 'ethnicities', 'states', 'countries', 'suffixes', 'prefixes', 'languages', 'genders', 'religions', 'occupations', 'contact_types', 'subcontact_types', 'referrals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-contact');
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_home' => 'email|nullable',
            'email_work' => 'email|nullable',
            'email_other' => 'email|nullable',
            'birth_date' => 'date|nullable',
            'deceased_date' => 'date|nullable',
            'url_main' => 'url|nullable',
            'url_work' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\.com\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\.google\.com\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\.com\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\.com\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\.com\/.+/i|nullable',
            'parish_id' => 'integer|min:0|nullable',
            'gender_id' => 'integer|min:0|nullable',
            'ethnicity_id' => 'integer|min:0|nullable',
            'religion_id' => 'integer|min:0|nullable',
            'contact_type' => 'integer|min:0|nullable',
            'subcontact_type' => 'integer|min:0|nullable',
            'occupation_id' => 'integer|min:0|nullable',
            'avatar' => 'image|max:5000|nullable',
            'emergency_contact_phone' => 'phone|nullable',
            'emergency_contact_phone_alternate' => 'phone|nullable',
            'phone_home_phone' => 'phone|nullable',
            'phone_home_mobile' => 'phone|nullable',
            'phone_home_fax' => 'phone|nullable',
            'phone_work_phone' => 'phone|nullable',
            'phone_work_mobile' => 'phone|nullable',
            'phone_work_fax' => 'phone|nullable',
            'phone_other_phone' => 'phone|nullable',
            'phone_other_mobile' => 'phone|nullable',
            'phone_other_fax' => 'phone|nullable',
        ]);
        $person = new \montserrat\Contact;
        
        // name info
        $person->prefix_id = $request->input('prefix_id');
        $person->first_name = $request->input('first_name');
        $person->middle_name = $request->input('middle_name');
        $person->last_name = $request->input('last_name');
        $person->suffix_id = $request->input('suffix_id');
        $person->nick_name = $request->input('nick_name');
        $person->contact_type = $request->input('contact_type');
        $person->subcontact_type = $request->input('subcontact_type');
        // the sort and display names are not available on creation so that we create a default and then it can be customized or tweaked individually
        if (empty($request->input('display_name'))) {
            $person->display_name = $person->first_name.' '.$person->last_name;
        } else {
            $person->display_name = $request->input('display_name');
        }
        if (empty($request->input('sort_name'))) {
            $person->sort_name = $person->last_name.', '.$person->first_name;
        } else {
            $person->sort_name = $request->input('sort_name');
        }

        // demographic info
        $person->gender_id = $request->input('gender_id');
        $person->birth_date= $request->input('birth_date');
        $person->ethnicity_id = $request->input('ethnicity_id');
        $person->religion_id = $request->input('religion_id');
        $person->occupation_id = $request->input('occupation_id');
        
        // communication preferences
        if (empty($request->input('do_not_mail'))) {
                $person->do_not_mail = 0;
        } else {
            $person->do_not_mail = $request->input('do_not_mail');
        }
        if (empty($request->input('do_not_email'))) {
                $person->do_not_email = 0;
        } else {
            $person->do_not_email = $request->input('do_not_email');
        }
        
        if (empty($request->input('do_not_phone'))) {
                $person->do_not_phone = 0;
        } else {
            $person->do_not_phone = $request->input('do_not_phone');
        }
        
        if (empty($request->input('do_not_sms'))) {
                $person->do_not_sms = 0;
        } else {
            $person->do_not_sms = $request->input('do_not_sms');
        }
        
        
        // CiviCRM stores the language name rather than the language id in the contact's preferred_language field
        if (!empty($request->input('preferred_language_id'))) {
            $language = \montserrat\Language::findOrFail($request->input('preferred_language_id'));
            $person->preferred_language = $language->name;
        }
        
        if (empty($request->input('is_deceased'))) {
                $person->is_deceased = 0;
        } else {
            $person->is_deceased = $request->input('is_deceased');
        }
        if (empty($request->input('deceased_date'))) {
                $person->deceased_date = null;
        } else {
            $person->deceased_date = $request->input('deceased_date');
        }
        
        $person->save();
        if (null !== $request->file('avatar')) {
            $description = 'Avatar for '.$person->full_name;
            $attachment = new AttachmentsController;
            $attachment->store_attachment($request->file('avatar'), 'contact', $person->id, 'avatar', $description);
        }
        // emergency contact information - not part of CiviCRM squema
        $emergency_contact = new \montserrat\EmergencyContact;
            $emergency_contact->contact_id=$person->id;
            $emergency_contact->name=$request->input('emergency_contact_name');
            $emergency_contact->relationship=$request->input('emergency_contact_relationship');
            $emergency_contact->phone=$request->input('emergency_contact_phone');
            $emergency_contact->phone_alternate=$request->input('emergency_contact_phone_alternate');
        $emergency_contact->save();
       
        // relationships: parishioner, donor, retreatant, volunteer, captain, director, innkeeper, assistant, staff, board
        
        // save parishioner relationship
        if ($request->input('parish_id')>0) {
            $relationship_parishioner = new \montserrat\Relationship;
                $relationship_parishioner->contact_id_a = $request->input('parish_id');
                $relationship_parishioner->contact_id_b = $person->id;
                $relationship_parishioner->relationship_type_id = RELATIONSHIP_TYPE_PARISHIONER;
                $relationship_parishioner->is_active = 1;
            $relationship_parishioner->save();
        }
        
        // save donor relationship
        if ($request->input('is_donor')>0) {
            $relationship_donor = new \montserrat\Relationship;
                $relationship_donor->contact_id_a = CONTACT_MONTSERRAT;
                $relationship_donor->contact_id_b = $person->id;
                $relationship_donor->relationship_type_id = RELATIONSHIP_TYPE_DONOR;
                $relationship_donor->is_active = 1;
            $relationship_donor->save();
        }
        
        // save retreatant relationship
        if ($request->input('is_retreatant')>0) {
            $relationship_retreatant = new \montserrat\Relationship;
                $relationship_retreatant->contact_id_a = CONTACT_MONTSERRAT;
                $relationship_retreatant->contact_id_b = $person->id;
                $relationship_retreatant->relationship_type_id = RELATIONSHIP_TYPE_RETREATANT;
                $relationship_retreatant->is_active = 1;
            $relationship_retreatant->save();
        }
        
        // save volunteer relationship
        if ($request->input('is_volunteer')>0) {
            $relationship_volunteer= new \montserrat\Relationship;
                $relationship_volunteer->contact_id_a = CONTACT_MONTSERRAT;
                $relationship_volunteer->contact_id_b = $person->id;
                $relationship_volunteer->relationship_type_id = RELATIONSHIP_TYPE_VOLUNTEER;
                $relationship_volunteer->is_active = 1;
            $relationship_volunteer->save();
            $group_volunteer = new \montserrat\GroupContact;
                $group_volunteer->group_id = GROUP_ID_VOLUNTEER;
                $group_volunteer->contact_id = $person->id;
                $group_volunteer->status = 'Added';
            $group_volunteer->save();
        }
        
        // save captain relationship
        if ($request->input('is_captain')>0) {
            $relationship_captain= new \montserrat\Relationship;
                $relationship_captain->contact_id_a = CONTACT_MONTSERRAT;
                $relationship_captain->contact_id_b = $person->id;
                $relationship_captain->relationship_type_id = RELATIONSHIP_TYPE_CAPTAIN;
                $relationship_captain->is_active = 1;
            $relationship_captain->save();
            $group_captain = new \montserrat\GroupContact;
                $group_captain->group_id = GROUP_ID_CAPTAIN;
                $group_captain->contact_id = $person->id;
                $group_captain->status = 'Added';
            $group_captain->save();
        }
        // save retreat director relationship
        if ($request->input('is_director')>0) {
            $relationship_director= new \montserrat\Relationship;
                $relationship_director->contact_id_a = CONTACT_MONTSERRAT;
                $relationship_director->contact_id_b = $person->id;
                $relationship_director->relationship_type_id = RELATIONSHIP_TYPE_RETREAT_DIRECTOR;
                $relationship_director->is_active = 1;
            $relationship_director->save();
            $group_director = new \montserrat\GroupContact;
                $group_director->group_id = GROUP_ID_DIRECTOR;
                $group_director->contact_id = $person->id;
                $group_director->status = 'Added';
            $group_director->save();
        }
        // save retreat innkeeper relationship
        if ($request->input('is_innkeeper')>0) {
            $relationship_innkeeper= new \montserrat\Relationship;
                $relationship_innkeeper->contact_id_a = CONTACT_MONTSERRAT;
                $relationship_innkeeper->contact_id_b = $person->id;
                $relationship_innkeeper->relationship_type_id = RELATIONSHIP_TYPE_RETREAT_INNKEEPER;
                $relationship_innkeeper->is_active = 1;
            $relationship_innkeeper->save();
            $group_innkeeper = new \montserrat\GroupContact;
                $group_innkeeper->group_id = GROUP_ID_INNKEEPER;
                $group_innkeeper->contact_id = $person->id;
                $group_innkeeper->status = 'Added';
            $group_innkeeper->save();
        }
        // save retreat assistant relationship
        if ($request->input('is_assistant')>0) {
            $relationship_assistant= new \montserrat\Relationship;
                $relationship_assistant->contact_id_a = CONTACT_MONTSERRAT;
                $relationship_assistant->contact_id_b = $person->id;
                $relationship_assistant->relationship_type_id = RELATIONSHIP_TYPE_RETREAT_ASSISTANT;
                $relationship_assistant->is_active = 1;
            $relationship_assistant->save();
            $group_assistant = new \montserrat\GroupContact;
                $group_assistant->group_id = GROUP_ID_ASSISTANT;
                $group_assistant->contact_id = $person->id;
                $group_assistant->status = 'Added';
            $group_assistant->save();
        }
        // save staff relationship - nb that the individual is contact_a and organization is contact_b
        if ($request->input('is_staff')>0) {
            $relationship_staff= new \montserrat\Relationship;
                $relationship_staff->contact_id_a = $person->id;
                $relationship_staff->contact_id_b = CONTACT_MONTSERRAT;
                $relationship_staff->relationship_type_id = RELATIONSHIP_TYPE_STAFF;
                $relationship_staff->is_active = 1;
            $relationship_staff->save();
            $group_staff = new \montserrat\GroupContact;
                $group_staff->group_id = GROUP_ID_STAFF;
                $group_staff->contact_id = $person->id;
                $group_staff->status = 'Added';
            $group_staff->save();
        }
        // save steward group
        if ($request->input('is_steward')>0) {
            $group_steward = new \montserrat\GroupContact;
                $group_steward->group_id = GROUP_ID_STEWARD;
                $group_steward->contact_id = $person->id;
                $group_steward->status = 'Added';
            $group_steward->save();
        }
        // save board member relationship
        if ($request->input('is_board')>0) {
            $relationship_board= new \montserrat\Relationship;
                $relationship_board->contact_id_a = CONTACT_MONTSERRAT;
                $relationship_board->contact_id_b = $person->id;
                $relationship_board->relationship_type_id = RELATIONSHIP_TYPE_BOARD_MEMBER;
                $relationship_board->start_date = \Carbon\Carbon::now();
                $relationship_board->is_active = 1;
            $relationship_board->save();
            $group_board = new \montserrat\GroupContact;
                $group_board->group_id = GROUP_ID_BOARD;
                $group_board->contact_id = $person->id;
                $group_board->status = 'Added';
            $group_board->save();
        }
        
        //groups: deacon, priest, bishop, pastor, jesuit, provincial, superior, captain, board, innkeeper, director, assistant, staff
        
        if ($request->input('is_bishop')>0) {
            $group_bishop = new \montserrat\GroupContact;
                $group_bishop->group_id = GROUP_ID_BISHOP;
                $group_bishop->contact_id = $person->id;
                $group_bishop->status = 'Added';
            $group_bishop->save();
        }
        if ($request->input('is_priest')>0) {
            $group_priest = new \montserrat\GroupContact;
                $group_priest->group_id = GROUP_ID_PRIEST;
                $group_priest->contact_id = $person->id;
                $group_priest->status = 'Added';
            $group_priest->save();
        }
        if ($request->input('is_deacon')>0) {
            $group_deacon = new \montserrat\GroupContact;
                $group_deacon->group_id = GROUP_ID_DEACON;
                $group_deacon->contact_id = $person->id;
                $group_deacon->status = 'Added';
            $group_deacon->save();
        }
        if ($request->input('is_pastor')>0) {
            $group_pastor = new \montserrat\GroupContact;
                $group_pastor->group_id = GROUP_ID_PASTOR;
                $group_pastor->contact_id = $person->id;
                $group_pastor->status = 'Added';
            $group_pastor->save();
        }
        if ($request->input('is_jesuit')>0) {
            $group_jesuit = new \montserrat\GroupContact;
                $group_jesuit->group_id = GROUP_ID_JESUIT;
                $group_jesuit->contact_id = $person->id;
                $group_jesuit->status = 'Added';
            $group_jesuit->save();
        }
        if ($request->input('is_superior')>0) {
            $group_superior = new \montserrat\GroupContact;
                $group_superior->group_id = GROUP_ID_SUPERIOR;
                $group_superior->contact_id = $person->id;
                $group_superior->status = 'Added';
            $group_superior->save();
        }
        if ($request->input('is_provincial')>0) {
            $group_provincial = new \montserrat\GroupContact;
                $group_provincial->group_id = GROUP_ID_PROVINCIAL;
                $group_provincial->contact_id = $person->id;
                $group_provincial->status = 'Added';
            $group_provincial->save();
        }
        
        
        /*
        $this->save_relationship('parish_id',$parish_id,$person->id,RELATIONSHIP_TYPE_PARISHIONER);
        $this->save_relationship('is_donor',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_DONOR);
        $this->save_relationship('is_retreatant',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_RETREATANT);
        $this->save_relationship('is_volunteer',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_VOLUNTEER);
        $this->save_relationship('is_captain',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_CAPTAIN);
        $this->save_relationship('is_director',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_RETREAT_DIRECTOR);
        $this->save_relationship('is_innkeeper',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_RETREAT_INNKEEPER);
        $this->save_relationship('is_assistant',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_RETREAT_ASSISTANT);
        $this->save_relationship('is_staff',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_STAFF);
        $this->save_relationship('is_board',CONTACT_MONTSERRAT,$person->id,RELATIONSHIP_TYPE_BOARD_MEMBER);
        */
            
        // save health, dietary, general and room preference notes
        
        if (!empty($request->input('note_health'))) {
            $person_note_health = new \montserrat\Note;
            $person_note_health->entity_table = 'contact';
            $person_note_health->entity_id = $person->id;
            $person_note_health->note=$request->input('note_health');
            $person_note_health->subject='Health Note';
            $person_note_health->save();
        }
        
        if (!empty($request->input('note_dietary'))) {
            $person_note_dietary = new \montserrat\Note;
            $person_note_dietary->entity_table = 'contact';
            $person_note_dietary->entity_id = $person->id;
            $person_note_dietary->note=$request->input('note_dietary');
            $person_note_dietary->subject='Dietary Note';
            $person_note_dietary->save();
        }
        
        if (!empty($request->input('note_contact'))) {
            $person_note_contact = new \montserrat\Note;
            $person_note_contact->entity_table = 'contact';
            $person_note_contact->entity_id = $person->id;
            $person_note_contact->note=$request->input('note_contact');
            $person_note_contact->subject='Contact Note';
            $person_note_contact->save();
        }
        
        if (!empty($request->input('note_room_preference'))) {
            $person_note_room_preference = new \montserrat\Note;
            $person_note_room_preference->entity_table = 'contact';
            $person_note_room_preference->entity_id = $person->id;
            $person_note_room_preference->note=$request->input('note_room_preference');
            $person_note_room_preference->subject='Room Preference';
            $person_note_room_preference->save();
        }
        
        if (empty($request->input('languages')) or in_array(0, $request->input('languages'))) {
            $person->languages()->detach();
        } else {
            $person->languages()->sync($request->input('languages'));
        }
        if (empty($request->input('referrals')) or in_array(0, $request->input('referrals'))) {
            $person->referrals()->detach();
        } else {
            $person->referrals()->sync($request->input('referrals'));
        }
        
        $home_address= new \montserrat\Address;
            $home_address->contact_id=$person->id;
            $home_address->location_type_id=LOCATION_TYPE_HOME;
            $home_address->is_primary=1;
            $home_address->street_address=$request->input('address_home_address1');
            $home_address->supplemental_address_1=$request->input('address_home_address2');
            $home_address->city=$request->input('address_home_city');
            $home_address->state_province_id=$request->input('address_home_state');
            $home_address->postal_code=$request->input('address_home_zip');
            $home_address->country_id=$request->input('address_home_country');
            $home_address->save();
        
        $work_address= new \montserrat\Address;
        $work_address->contact_id=$person->id;
            $work_address->location_type_id=LOCATION_TYPE_WORK;
            $work_address->is_primary=0;
            $work_address->street_address=$request->input('address_work_address1');
            $work_address->supplemental_address_1=$request->input('address_work_address2');
            $work_address->city=$request->input('address_work_city');
            $work_address->state_province_id=$request->input('address_work_state');
            $work_address->postal_code=$request->input('address_work_zip');
            $work_address->country_id=$request->input('address_work_country');
        $work_address->save();
        
        $other_address= new \montserrat\Address;
        $other_address->contact_id=$person->id;
            $other_address->location_type_id=LOCATION_TYPE_OTHER;
            $other_address->is_primary=0;
            $other_address->street_address=$request->input('address_other_address1');
            $other_address->supplemental_address_1=$request->input('address_other_address2');
            $other_address->city=$request->input('address_other_city');
            $other_address->state_province_id=$request->input('address_other_state');
            $other_address->postal_code=$request->input('address_other_zip');
            $other_address->country_id=$request->input('address_other_country');
        $other_address->save();
        
        $phone_home_phone= new \montserrat\Phone;
            $phone_home_phone->contact_id=$person->id;
            $phone_home_phone->location_type_id=LOCATION_TYPE_HOME;
            $phone_home_phone->phone=$request->input('phone_home_phone');
            $phone_home_phone->phone_type='Phone';
        $phone_home_phone->save();
        
        $phone_home_mobile= new \montserrat\Phone;
            $phone_home_mobile->contact_id=$person->id;
            $phone_home_mobile->location_type_id=LOCATION_TYPE_HOME;
            $phone_home_mobile->phone=$request->input('phone_home_mobile');
            $phone_home_mobile->phone_type='Mobile';
        $phone_home_mobile->save();
        
        $phone_home_fax= new \montserrat\Phone;
            $phone_home_fax->contact_id=$person->id;
            $phone_home_fax->location_type_id=LOCATION_TYPE_HOME;
            $phone_home_fax->phone=$request->input('phone_home_fax');
            $phone_home_fax->phone_type='Fax';
        $phone_home_fax->save();
        
        $phone_work_phone= new \montserrat\Phone;
            $phone_work_phone->contact_id=$person->id;
            $phone_work_phone->location_type_id=LOCATION_TYPE_WORK;
            $phone_work_phone->phone=$request->input('phone_work_phone');
            $phone_work_phone->phone_type='Phone';
        $phone_work_phone->save();
        
        $phone_work_mobile= new \montserrat\Phone;
            $phone_work_mobile->contact_id=$person->id;
            $phone_work_mobile->location_type_id=LOCATION_TYPE_WORK;
            $phone_work_mobile->phone=$request->input('phone_work_mobile');
            $phone_work_mobile->phone_type='Mobile';
        $phone_work_mobile->save();
        
        $phone_work_fax= new \montserrat\Phone;
            $phone_work_fax->contact_id=$person->id;
            $phone_work_fax->location_type_id=LOCATION_TYPE_WORK;
            $phone_work_fax->phone=$request->input('phone_work_fax');
            $phone_work_fax->phone_type='Fax';
        $phone_work_fax->save();
        
        $phone_other_phone= new \montserrat\Phone;
            $phone_other_phone->contact_id=$person->id;
            $phone_other_phone->location_type_id=LOCATION_TYPE_OTHER;
            $phone_other_phone->phone=$request->input('phone_other_phone');
            $phone_other_phone->phone_type='Phone';
        $phone_other_phone->save();
        
        $phone_other_mobile= new \montserrat\Phone;
            $phone_other_mobile->contact_id=$person->id;
            $phone_other_mobile->location_type_id=LOCATION_TYPE_OTHER;
            $phone_other_mobile->phone=$request->input('phone_other_mobile');
            $phone_other_mobile->phone_type='Mobile';
        $phone_other_mobile->save();
        
        $phone_other_fax= new \montserrat\Phone;
            $phone_other_fax->contact_id=$person->id;
            $phone_other_fax->location_type_id=LOCATION_TYPE_OTHER;
            $phone_other_fax->phone=$request->input('phone_other_fax');
            $phone_other_fax->phone_type='Fax';
        $phone_other_fax->save();
        
        $email_home = new \montserrat\Email;
            $email_home->contact_id=$person->id;
            $email_home->location_type_id=LOCATION_TYPE_HOME;
            $email_home->email=$request->input('email_home');
            $email_home->is_primary=1;
        $email_home->save();
        
        $email_work= new \montserrat\Email;
            $email_work->contact_id=$person->id;
            $email_work->location_type_id=LOCATION_TYPE_WORK;
            $email_work->email=$request->input('email_work');
        $email_work->save();
        
        $email_other = new \montserrat\Email;
            $email_other->contact_id=$person->id;
            $email_other->location_type_id=LOCATION_TYPE_OTHER;
            $email_other->email=$request->input('email_other');
        $email_other->save();
        
        $url_main = new \montserrat\Website;
            $url_main->contact_id=$person->id;
            $url_main->url=$request->input('url_main');
            $url_main->website_type='Main';
        $url_main->save();
        
        $url_work= new \montserrat\Website;
            $url_work->contact_id=$person->id;
            $url_work->url=$request->input('url_work');
            $url_work->website_type='Work';
        $url_work->save();
        
        $url_facebook= new \montserrat\Website;
            $url_facebook->contact_id=$person->id;
            $url_facebook->url=$request->input('url_facebook');
            $url_facebook->website_type='Facebook';
        $url_facebook->save();
        
        $url_google = new \montserrat\Website;
            $url_google->contact_id=$person->id;
            $url_google->url=$request->input('url_google');
            $url_google->website_type='Google';
        $url_google->save();
        
        $url_instagram= new \montserrat\Website;
            $url_instagram->contact_id=$person->id;
            $url_instagram->url=$request->input('url_instagram');
            $url_instagram->website_type='Instagram';
        $url_instagram->save();
        
        $url_linkedin= new \montserrat\Website;
            $url_linkedin->contact_id=$person->id;
            $url_linkedin->url=$request->input('url_linkedin');
            $url_linkedin->website_type='LinkedIn';
        $url_linkedin->save();
        
        $url_twitter= new \montserrat\Website;
            $url_twitter->contact_id=$person->id;
            $url_twitter->url=$request->input('url_twitter');
            $url_twitter->website_type='Twitter';
        $url_twitter->save();

        return Redirect::action('PersonsController@show', $person->id);//
        
        //return Redirect::action('PersonsController@index');//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-contact');
        $person = \montserrat\Contact::with('addresses.country', 'addresses.location', 'addresses.state', 'emails.location', 'emergency_contact', 'ethnicity', 'languages', 'notes', 'occupation', 'parish.contact_a.address_primary', 'parish.contact_a.diocese.contact_a', 'phones.location', 'prefix', 'suffix', 'religion', 'touchpoints.staff', 'websites', 'groups.group', 'a_relationships.relationship_type', 'a_relationships.contact_b', 'b_relationships.relationship_type', 'b_relationships.contact_a', 'event_registrations')->findOrFail($id);
        $files = \montserrat\Attachment::whereEntity('contact')->whereEntityId($person->id)->whereFileTypeId(FILE_TYPE_CONTACT_ATTACHMENT)->get();
        $relationship_types = [];
        $relationship_types["Child"] = "Child";
        $relationship_types["Employee"] = "Employee";
        $relationship_types["Husband"] = "Husband";
        $relationship_types["Parent"] = "Parent";
        $relationship_types["Parishioner"] = "Parishioner";
        $relationship_types["Sibling"] = "Sibling";
        $relationship_types["Wife"] = "Wife";
       
        //dd($files);
        //not at all elegant but this parses out the notes for easy display and use in the edit blade
        $person->note_health='';
        $person->note_dietary='';
        $person->note_contact='';
        $person->note_room_preference='';
        if (!empty($person->notes)) {
            foreach ($person->notes as $note) {
                if ($note->subject=="Health Note") {
                    $person->note_health = $note->note;
                }

                if ($note->subject=='Dietary Note') {
                    $person->note_dietary = $note->note;
                }

                if ($note->subject=='Contact Note') {
                    $person->note_contact = $note->note;
                }

                if ($note->subject=='Room Preference') {
                    $person->note_room_preference = $note->note;
                }
            }
        }
        
        //not pretty but moves some of the processing to the controller rather than the blade
        $person->parish_id='';
        $person->parish_name = '';
        if (!empty($person->parish)) {
            $person->parish_id = $person->parish->contact_id_a;
            $person->parish_name = $person->parish->contact_a->organization_name.' ('.$person->parish->contact_a->address_primary->city.') - '.$person->parish->contact_a->diocese->contact_a->organization_name;
        }
       
        $preferred_language = \montserrat\Language::whereName($person->preferred_language)->first();
        if (!empty($preferred_language)) {
            $person->preferred_language_label=$preferred_language->label;
        } else {
            $person->preferred_language_label = 'N/A';
        }
        $touchpoints = \montserrat\Touchpoint::wherePersonId($person->id)->orderBy('touched_at', 'desc')->with('staff')->get();
       //dd($touchpoints);
        return view('persons.show', compact('person', 'files', 'relationship_types', 'touchpoints'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-contact');
        $person = \montserrat\Contact::with('prefix', 'suffix', 'addresses.location', 'emails.location', 'phones.location', 'websites', 'parish', 'emergency_contact', 'notes')->findOrFail($id);
        //dd($person);
        
        $parishes = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PARISH)->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        $parish_list[0]='N/A';
        $contact_types = \montserrat\ContactType::whereIsReserved(true)->pluck('label', 'id');
        $subcontact_types = \montserrat\ContactType::whereIsReserved(false)->whereIsActive(true)->pluck('label', 'id');
        $subcontact_types->prepend('N/A', 0);
        // while probably not the most efficient way of doing this it gets me the result
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }
        if (!empty($person->parish)) {
            $person->parish_id = $person->parish->contact_id_a;
        } else {
            $person->parish_id = 0;
        }
        $preferred_language = \montserrat\Language::whereName($person->preferred_language)->first();
        if (!empty($preferred_language)) {
            $person->preferred_language_id=$preferred_language->id;
        } else {
            $person->preferred_language_id = 0;
        }
        
        //again not at all elegant but this parses out the notes for easy display and use in the edit blade
        $person->note_health='';
        $person->note_dietary='';
        $person->note_contact='';
        $person->note_room_preference='';
        
        if (!empty($person->notes)) {
            foreach ($person->notes as $note) {
                if ($note->subject=="Health Note") {
                    $person->note_health = $note->note;
                }

                if ($note->subject=='Dietary Note') {
                    $person->note_dietary = $note->note;
                }

                if ($note->subject=='Contact Note') {
                    $person->note_contact = $note->note;
                }

                if ($note->subject=='Room Preference') {
                    $person->note_room_preference = $note->note;
                }
            }
        }
        //dd($person);
        $countries = \montserrat\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);
        $ethnicities = \montserrat\Ethnicity::orderBy('ethnicity')->pluck('ethnicity', 'id');
        $ethnicities->prepend('N/A', 0);
        $genders = \montserrat\Gender::orderBy('name')->pluck('name', 'id');
        $genders ->prepend('N/A', 0);
        $languages = \montserrat\Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('N/A', 0);
        $referrals = \montserrat\Referral::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $referrals->prepend('N/A', 0);
        $prefixes= \montserrat\Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('N/A', 0);
        $religions = \montserrat\Religion::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $religions->prepend('N/A', 0);
        $states = \montserrat\StateProvince::orderBy('name')->whereCountryId(1228)->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $suffixes = \montserrat\Suffix::orderBy('name')->pluck('name', 'id');
        $suffixes->prepend('N/A', 0);
        $occupations = \montserrat\Ppd_occupation::orderBy('name')->pluck('name', 'id');
        $occupations->prepend('N/A', 0);
        
        //create defaults array for easier pre-populating of default values on edit/update blade
        // initialize defaults to avoid undefined index errors
        $defaults = [];
        $defaults['Home']['street_address']='';
        $defaults['Home']['supplemental_address_1']='';
        $defaults['Home']['city']='';
        $defaults['Home']['state_province_id']='';
        $defaults['Home']['postal_code']='';
        $defaults['Home']['country_id']='';
        $defaults['Home']['Phone']='';
        $defaults['Home']['Mobile']='';
        $defaults['Home']['Fax']='';
        $defaults['Home']['email']='';
        
        $defaults['Work']['street_address']='';
        $defaults['Work']['supplemental_address_1']='';
        $defaults['Work']['city']='';
        $defaults['Work']['state_province_id']='';
        $defaults['Work']['postal_code']='';
        $defaults['Work']['country_id']='';
        $defaults['Work']['Phone']='';
        $defaults['Work']['Mobile']='';
        $defaults['Work']['Fax']='';
        $defaults['Work']['email']='';
        
        $defaults['Other']['street_address']='';
        $defaults['Other']['supplemental_address_1']='';
        $defaults['Other']['city']='';
        $defaults['Other']['state_province_id']='';
        $defaults['Other']['postal_code']='';
        $defaults['Other']['country_id']='';
        $defaults['Other']['Phone']='';
        $defaults['Other']['Mobile']='';
        $defaults['Other']['Fax']='';
        $defaults['Other']['email']='';
        
        $defaults['Main']['url']='';
        $defaults['Work']['url']='';
        $defaults['Facebook']['url']='';
        $defaults['Google']['url']='';
        $defaults['Instagram']['url']='';
        $defaults['LinkedIn']['url']='';
        $defaults['Twitter']['url']='';
        
        foreach ($person->addresses as $address) {
            $defaults[$address->location->name]['street_address'] = $address->street_address;
            $defaults[$address->location->name]['supplemental_address_1'] = $address->supplemental_address_1;
            $defaults[$address->location->name]['city'] = $address->city;
            $defaults[$address->location->name]['state_province_id'] = $address->state_province_id;
            $defaults[$address->location->name]['postal_code'] = $address->postal_code;
            $defaults[$address->location->name]['country_id'] = $address->country_id;
        }
        
        foreach ($person->phones as $phone) {
            $defaults[$phone->location->name][$phone->phone_type] = $phone->phone;
        }
        
        foreach ($person->emails as $email) {
            $defaults[$email->location->name]['email'] = $email->email;
        }
        
        foreach ($person->websites as $website) {
            $defaults[$website->website_type]['url'] = $website->url;
        }
        //dd($person);

        return view('persons.edit', compact('prefixes', 'suffixes', 'person', 'parish_list', 'ethnicities', 'states', 'countries', 'genders', 'languages', 'defaults', 'religions', 'occupations', 'contact_types', 'subcontact_types', 'referrals'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update-contact');
        
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_home' => 'email|nullable',
            'email_work' => 'email|nullable',
            'email_other' => 'email|nullable',
            'birth_date' => 'date|nullable',
            'deceased_date' => 'date|nullable',
            'url_main' => 'url|nullable',
            'url_work' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\.com\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\.google\.com\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\.com\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\.com\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\.com\/.+/i|nullable',
            'parish_id' => 'integer|min:0|nullable',
            'gender_id' => 'integer|min:0|nullable',
            'ethnicity_id' => 'integer|min:0|nullable',
            'religion_id' => 'integer|min:0|nullable',
            'contact_type' => 'integer|min:0|nullable',
            'subcontact_type' => 'integer|min:0|nullable',
            'occupation_id' => 'integer|min:0|nullable',
            'avatar' => 'image|max:5000|nullable',
            'attachment' => 'file|mimes:pdf,doc,docx|max:10000|nullable',
            'attachment_description' => 'string|max:200|nullable',
            'emergency_contact_phone' => 'phone|nullable',
            'emergency_contact_phone_alternate' => 'phone|nullable',
            'phone_home_phone' => 'phone|nullable',
            'phone_home_mobile' => 'phone|nullable',
            'phone_home_fax' => 'phone|nullable',
            'phone_work_phone' => 'phone|nullable',
            'phone_work_mobile' => 'phone|nullable',
            'phone_work_fax' => 'phone|nullable',
            'phone_other_phone' => 'phone|nullable',
            'phone_other_mobile' => 'phone|nullable',
            'phone_other_fax' => 'phone|nullable',
        
            ]);
        //dd($request);
        //name
        $person = \montserrat\Contact::with('addresses.location', 'emails.location', 'phones.location', 'websites', 'emergency_contact', 'parish')->findOrFail($id);
        $person->prefix_id = $request->input('prefix_id');
        $person->first_name = $request->input('first_name');
        $person->middle_name = $request->input('middle_name');
        $person->last_name = $request->input('last_name');
        $person->suffix_id = $request->input('suffix_id');
        $person->nick_name = $request->input('nick_name');
        $person->contact_type = $request->input('contact_type');
        $person->subcontact_type = $request->input('subcontact_type');
        
        if (empty($request->input('display_name'))) {
            $person->display_name = $person->first_name.' '.$person->last_name;
        } else {
            $person->display_name = $request->input('display_name');
        }
        if (empty($request->input('sort_name'))) {
            $person->sort_name = $person->last_name.', '.$person->first_name;
        } else {
            $person->sort_name = $request->input('sort_name');
        }

        //demographic info
        $person->gender_id = $request->input('gender_id');
        $person->birth_date = $request->input('birth_date');
        $person->ethnicity_id = $request->input('ethnicity_id');
        $person->religion_id = $request->input('religion_id');
        $person->occupation_id = $request->input('occupation_id');
        
        // communication preferences
    $person->do_not_mail = $request->input('do_not_mail') ?: 0;
        $person->do_not_email = $request->input('do_not_email') ?: 0;
        $person->do_not_phone = $request->input('do_not_phone') ?: 0;
        $person->do_not_sms = $request->input('do_not_sms')?: 0;
        
        if (empty($request->input('languages')) or in_array(0, $request->input('languages'))) {
            $person->languages()->detach();
        } else {
            $person->languages()->sync($request->input('languages'));
        }
        if (empty($request->input('referrals')) or in_array(0, $request->input('referrals'))) {
            $person->referrals()->detach();
        } else {
            $person->referrals()->sync($request->input('referrals'));
        }
        
        // CiviCRM stores the language name rather than the language id in the contact's preferred_language field
        if (!empty($request->input('preferred_language_id'))) {
            $language = \montserrat\Language::findOrFail($request->input('preferred_language_id'));
            $person->preferred_language = $language->name;
        }
        if (empty($request->input('is_deceased'))) {
                $person->is_deceased = 0;
        } else {
            $person->is_deceased = $request->input('is_deceased');
        }
        if (empty($request->input('deceased_date'))) {
                $person->deceased_date = null;
        } else {
            $person->deceased_date = $request->input('deceased_date');
        }
        
        $person->save();
        if (null !== $request->file('avatar')) {
            $description = 'Avatar for '.$person->full_name;
            $attachment = new AttachmentsController;
            $attachment->update_attachment($request->file('avatar'), 'contact', $person->id, 'avatar', $description);
        }

        //dd($request);
        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentsController;
            $attachment->update_attachment($request->file('attachment'), 'contact', $person->id, 'attachment', $description);
        }
        
        //emergency contact info
        $emergency_contact = \montserrat\EmergencyContact::firstOrNew(['contact_id'=>$person->id]);
            $emergency_contact->contact_id=$person->id;
            $emergency_contact->name = $request->input('emergency_contact_name');
            $emergency_contact->relationship = $request->input('emergency_contact_relationship');
            $emergency_contact->phone = $request->input('emergency_contact_phone');
            $emergency_contact->phone_alternate = $request->input('emergency_contact_phone_alternate');
        $emergency_contact->save();
        
        //dd($person);
        // save parishioner relationship
        // TEST: does unset work?
        if ($request->input('parish_id')>0) {
                $relationship_parishioner = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_PARISHIONER,'is_active'=>1]);
                $relationship_parishioner->contact_id_a = $request->input('parish_id');
                $relationship_parishioner->contact_id_b = $person->id;
                $relationship_parishioner->relationship_type_id = RELATIONSHIP_TYPE_PARISHIONER;
                $relationship_parishioner->is_active = 1;
            $relationship_parishioner->save();
        }
        if ($request->input('parish_id')==0) {
                $relationship_parishioner = \montserrat\Relationship::whereContactIdB($person->id)->whereRelationshipTypeId(RELATIONSHIP_TYPE_PARISHIONER)->whereIsActive(1)->first();
            if (isset($relationship_parishioner)) {
                $relationship_parishioner->delete();
            }
        }
        
        
      // save health, dietary, general and room preference notes
        

        if (null !== ($request->input('note_health'))) {
            $person_note_health = \montserrat\Note::firstOrNew(['entity_table'=>'contact','entity_id'=>$person->id,'subject'=>'Health Note']);
            $person_note_health->entity_table = 'contact';
            $person_note_health->entity_id = $person->id;
            $person_note_health->note=$request->input('note_health');
            $person_note_health->subject='Health Note';
            $person_note_health->save();
        }
        
        if (null !== ($request->input('note_dietary'))) {
            $person_note_dietary = \montserrat\Note::firstOrNew(['entity_table'=>'contact','entity_id'=>$person->id,'subject'=>'Dietary Note']);
            $person_note_dietary->entity_table = 'contact';
            $person_note_dietary->entity_id = $person->id;
            $person_note_dietary->note=$request->input('note_dietary');
            $person_note_dietary->subject='Dietary Note';
            $person_note_dietary->save();
        }
        
        if (null !== ($request->input('note_contact'))) {
            $person_note_contact = \montserrat\Note::firstOrNew(['entity_table'=>'contact','entity_id'=>$person->id,'subject'=>'Contact Note']);
            $person_note_contact->entity_table = 'contact';
            $person_note_contact->entity_id = $person->id;
            $person_note_contact->note=$request->input('note_contact');
            $person_note_contact->subject='Contact Note';
            $person_note_contact->save();
        }
        
        if (null !== ($request->input('note_room_preference'))) {
            $person_note_room_preference = \montserrat\Note::firstOrNew(['entity_table'=>'contact','entity_id'=>$person->id,'subject'=>'Room Preference']);
            $person_note_room_preference->entity_table = 'contact';
            $person_note_room_preference->entity_id = $person->id;
            $person_note_room_preference->note=$request->input('note_room_preference');
            $person_note_room_preference->subject='Room Preference';
            $person_note_room_preference->save();
        }
                
        $home_address= \montserrat\Address::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME]);
            $home_address->contact_id=$person->id;
            $home_address->location_type_id=LOCATION_TYPE_HOME;
            $home_address->is_primary=1;
            $home_address->street_address=$request->input('address_home_address1');
            $home_address->supplemental_address_1=$request->input('address_home_address2');
            $home_address->city=$request->input('address_home_city');
            $home_address->state_province_id=$request->input('address_home_state');
            $home_address->postal_code=$request->input('address_home_zip');
            $home_address->country_id=$request->input('address_home_country');
        $home_address->save();
         
        $work_address= \montserrat\Address::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK]);
            $work_address->contact_id=$person->id;
            $work_address->location_type_id=LOCATION_TYPE_WORK;
            $work_address->is_primary=0;
            $work_address->street_address=$request->input('address_work_address1');
            $work_address->supplemental_address_1=$request->input('address_work_address2');
            $work_address->city=$request->input('address_work_city');
            $work_address->state_province_id=$request->input('address_work_state');
            $work_address->postal_code=$request->input('address_work_zip');
            $work_address->country_id=$request->input('address_work_country');
        $work_address->save();
        
        $other_address= \montserrat\Address::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER]);
            $other_address->contact_id=$person->id;
            $other_address->location_type_id=LOCATION_TYPE_OTHER;
            $other_address->is_primary=0;
            $other_address->street_address=$request->input('address_other_address1');
            $other_address->supplemental_address_1=$request->input('address_other_address2');
            $other_address->city=$request->input('address_other_city');
            $other_address->state_province_id=$request->input('address_other_state');
            $other_address->postal_code=$request->input('address_other_zip');
            $other_address->country_id=$request->input('address_other_country');
        $other_address->save();
        
        $phone_home_phone= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME,'phone_type'=>'Phone']);
            $phone_home_phone->contact_id=$person->id;
            $phone_home_phone->location_type_id=LOCATION_TYPE_HOME;
            $phone_home_phone->phone=$request->input('phone_home_phone');
            $phone_home_phone->phone_type='Phone';
        $phone_home_phone->save();
        
        $phone_home_mobile= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME,'phone_type'=>'Mobile']);
            $phone_home_mobile->contact_id=$person->id;
            $phone_home_mobile->location_type_id=LOCATION_TYPE_HOME;
            $phone_home_mobile->phone=$request->input('phone_home_mobile');
            $phone_home_mobile->phone_type='Mobile';
        $phone_home_mobile->save();
        
        $phone_home_fax= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME,'phone_type'=>'Fax']);
            $phone_home_fax->contact_id=$person->id;
            $phone_home_fax->location_type_id=LOCATION_TYPE_HOME;
            $phone_home_fax->phone=$request->input('phone_home_fax');
            $phone_home_fax->phone_type='Fax';
        $phone_home_fax->save();
        
        $phone_work_phone= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK,'phone_type'=>'Phone']);
            $phone_work_phone->contact_id=$person->id;
            $phone_work_phone->location_type_id=LOCATION_TYPE_WORK;
            $phone_work_phone->phone=$request->input('phone_work_phone');
            $phone_work_phone->phone_type='Phone';
        $phone_work_phone->save();
        
        $phone_work_mobile= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK,'phone_type'=>'Mobile']);
            $phone_work_mobile->contact_id=$person->id;
            $phone_work_mobile->location_type_id=LOCATION_TYPE_WORK;
            $phone_work_mobile->phone=$request->input('phone_work_mobile');
            $phone_work_mobile->phone_type='Mobile';
        $phone_work_mobile->save();
        
        $phone_work_fax= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK,'phone_type'=>'Fax']);
            $phone_work_fax->contact_id=$person->id;
            $phone_work_fax->location_type_id=LOCATION_TYPE_WORK;
            $phone_work_fax->phone=$request->input('phone_work_fax');
            $phone_work_fax->phone_type='Fax';
        $phone_work_fax->save();
        
        $phone_other_phone= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER,'phone_type'=>'Phone']);
            $phone_other_phone->contact_id=$person->id;
            $phone_other_phone->location_type_id=LOCATION_TYPE_OTHER;
            $phone_other_phone->phone=$request->input('phone_other_phone');
            $phone_other_phone->phone_type='Phone';
        $phone_other_phone->save();
        
        $phone_other_mobile= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER,'phone_type'=>'Mobile']);
            $phone_other_mobile->contact_id=$person->id;
            $phone_other_mobile->location_type_id=LOCATION_TYPE_OTHER;
            $phone_other_mobile->phone=$request->input('phone_other_mobile');
            $phone_other_mobile->phone_type='Mobile';
        $phone_other_mobile->save();
        
        $phone_other_fax= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER,'phone_type'=>'Fax']);
            $phone_other_fax->contact_id=$person->id;
            $phone_other_fax->location_type_id=LOCATION_TYPE_OTHER;
            $phone_other_fax->phone=$request->input('phone_other_fax');
            $phone_other_fax->phone_type='Fax';
        $phone_other_fax->save();
        
        $email_home = \montserrat\Email::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME]);
            $email_home->contact_id=$person->id;
            $email_home->location_type_id=LOCATION_TYPE_HOME;
            $email_home->email=$request->input('email_home');
        $email_home->save();
        
        $email_work= \montserrat\Email::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK]);
            $email_work->contact_id=$person->id;
            $email_work->location_type_id=LOCATION_TYPE_WORK;
            $email_work->email=$request->input('email_work');
        $email_work->save();
        
        $email_other = \montserrat\Email::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER]);
            $email_other->contact_id=$person->id;
            $email_other->location_type_id=LOCATION_TYPE_OTHER;
            $email_other->email=$request->input('email_other');
        $email_other->save();
        
        $url_main = \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Main']);
            $url_main->contact_id=$person->id;
            $url_main->url=$request->input('url_main');
            $url_main->website_type='Main';
        $url_main->save();
        
        $url_work= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Work']);
            $url_work->contact_id=$person->id;
            $url_work->url=$request->input('url_work');
            $url_work->website_type='Work';
        $url_work->save();
        
        $url_facebook= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Facebook']);
            $url_facebook->contact_id=$person->id;
            $url_facebook->url=$request->input('url_facebook');
            $url_facebook->website_type='Facebook';
        $url_facebook->save();
        
        $url_google = \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Google']);
            $url_google->contact_id=$person->id;
            $url_google->url=$request->input('url_google');
            $url_google->website_type='Google';
        $url_google->save();
        
        $url_instagram= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Instagram']);
            $url_instagram->contact_id=$person->id;
            $url_instagram->url=$request->input('url_instagram');
            $url_instagram->website_type='Instagram';
        $url_instagram->save();
        
        $url_linkedin= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'LinkedIn']);
            $url_linkedin->contact_id=$person->id;
            $url_linkedin->url=$request->input('url_linkedin');
            $url_linkedin->website_type='LinkedIn';
        $url_linkedin->save();
        
        $url_twitter= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Twitter']);
            $url_twitter->contact_id=$person->id;
            $url_twitter->url=$request->input('url_twitter');
            $url_twitter->website_type='Twitter';
        $url_twitter->save();
        
        // relationships: donor, retreatant, volunteer, captain, director, innkeeper, assistant, staff, board
        $relationship_donor = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_DONOR,'is_active'=>1]);
        if ($request->input('is_donor')==0) {
            $relationship_donor->delete();
        } else {
            $relationship_donor->contact_id_a = CONTACT_MONTSERRAT;
            $relationship_donor->contact_id_b = $person->id;
            $relationship_donor->relationship_type_id = RELATIONSHIP_TYPE_DONOR;
            $relationship_donor->is_active = 1;
            $relationship_donor->save();
        }
        $relationship_retreatant = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_RETREATANT,'is_active'=>1]);
        if ($request->input('is_retreatant')==0) {
            $relationship_retreatant->delete();
        } else {
            $relationship_retreatant->contact_id_a = CONTACT_MONTSERRAT;
            $relationship_retreatant->contact_id_b = $person->id;
            $relationship_retreatant->relationship_type_id = RELATIONSHIP_TYPE_RETREATANT;
            $relationship_retreatant->is_active = 1;
            $relationship_retreatant->save();
        }
        $relationship_volunteer = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_VOLUNTEER,'is_active'=>1]);
        if ($request->input('is_volunteer')==0) {
            $relationship_volunteer->delete();
        } else {
            $relationship_volunteer->contact_id_a = CONTACT_MONTSERRAT;
            $relationship_volunteer->contact_id_b = $person->id;
            $relationship_volunteer->relationship_type_id = RELATIONSHIP_TYPE_VOLUNTEER;
            $relationship_volunteer->is_active = 1;
            $relationship_volunteer->save();
        }
        $relationship_captain = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_CAPTAIN,'is_active'=>1]);
        if ($request->input('is_captain')==0) {
            $relationship_captain->delete();
        } else {
            $relationship_captain->contact_id_a = CONTACT_MONTSERRAT;
            $relationship_captain->contact_id_b = $person->id;
            $relationship_captain->relationship_type_id = RELATIONSHIP_TYPE_CAPTAIN;
            $relationship_captain->is_active = 1;
            $relationship_captain->save();
        }
        $relationship_director = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_RETREAT_DIRECTOR,'is_active'=>1]);
        if ($request->input('is_director')==0) {
            $relationship_director->delete();
        } else {
            $relationship_director->contact_id_a = CONTACT_MONTSERRAT;
            $relationship_director->contact_id_b = $person->id;
            $relationship_director->relationship_type_id = RELATIONSHIP_TYPE_RETREAT_DIRECTOR;
            $relationship_director->is_active = 1;
            $relationship_director->save();
        }
        $relationship_innkeeper = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_RETREAT_INNKEEPER,'is_active'=>1]);
        if ($request->input('is_innkeeper')==0) {
            $relationship_innkeeper->delete();
        } else {
            $relationship_innkeeper->contact_id_a = CONTACT_MONTSERRAT;
            $relationship_innkeeper->contact_id_b = $person->id;
            $relationship_innkeeper->relationship_type_id = RELATIONSHIP_TYPE_RETREAT_INNKEEPER;
            $relationship_innkeeper->is_active = 1;
            $relationship_innkeeper->save();
        }
        $relationship_assistant = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_RETREAT_ASSISTANT,'is_active'=>1]);
        if ($request->input('is_assistant')==0) {
            $relationship_assistant->delete();
        } else {
            $relationship_assistant->contact_id_a = CONTACT_MONTSERRAT;
            $relationship_assistant->contact_id_b = $person->id;
            $relationship_assistant->relationship_type_id = RELATIONSHIP_TYPE_RETREAT_ASSISTANT;
            $relationship_assistant->is_active = 1;
            $relationship_assistant->save();
        }
        $relationship_staff = \montserrat\Relationship::firstOrNew(['contact_id_a'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_STAFF,'is_active'=>1]);
        if ($request->input('is_staff')==0) {
            $relationship_staff->delete();
        } else {
            $relationship_staff->contact_id_a = $person->id;
            $relationship_staff->contact_id_b = CONTACT_MONTSERRAT;
            $relationship_staff->relationship_type_id = RELATIONSHIP_TYPE_STAFF;
            $relationship_staff->is_active = 1;
            $relationship_staff->save();
        }
        // for Board Members we are not deleting the relationship but ending it and making it inactive
        $relationship_board = \montserrat\Relationship::firstOrNew(['contact_id_b'=>$person->id,'relationship_type_id'=>RELATIONSHIP_TYPE_BOARD_MEMBER]);
        if ($request->input('is_board')==0) {
            if (isset($relationship_board->id)) {
                $relationship_board->end_date = \Carbon\Carbon::now();
                $relationship_board->is_active = 0;
                $relationship_board->save();
            }
        } else {
            $relationship_board->contact_id_a = CONTACT_MONTSERRAT;
            $relationship_board->contact_id_b = $person->id;
            $relationship_board->relationship_type_id = RELATIONSHIP_TYPE_BOARD_MEMBER;
            $relationship_board->start_date = \Carbon\Carbon::now();
            $relationship_board->is_active = 1;
            $relationship_board->save();
        }
        
            //groups:
        $group_captain = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_CAPTAIN,'status'=>'Added']);
        if ($request->input('is_captain')==0) {
            $group_captain->delete();
        } else {
            $group_captain->contact_id = $person->id;
            $group_captain->group_id = GROUP_ID_CAPTAIN;
            $group_captain->status = 'Added';
            $group_captain->deleted_at = null;
            $group_captain->save();
        }
        $group_volunteer = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_VOLUNTEER,'status'=>'Added']);
        if ($request->input('is_volunteer')==0) {
            $group_volunteer->delete();
        } else {
            $group_volunteer->contact_id = $person->id;
            $group_volunteer->group_id = GROUP_ID_VOLUNTEER;
            $group_volunteer->status = 'Added';
            $group_volunteer->deleted_at = null;
            $group_volunteer->save();
        }
        $group_bishop = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_BISHOP,'status'=>'Added']);
        if ($request->input('is_bishop')==0) {
            $group_bishop->delete();
        } else {
            $group_bishop->contact_id = $person->id;
            $group_bishop->group_id = GROUP_ID_BISHOP;
            $group_bishop->status = 'Added';
            $group_bishop->deleted_at = null;
            $group_bishop->save();
        }
        $group_priest = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_PRIEST,'status'=>'Added']);
        if ($request->input('is_priest')==0) {
            $group_priest->delete();
        } else {
            $group_priest->contact_id = $person->id;
            $group_priest->group_id = GROUP_ID_PRIEST;
            $group_priest->status = 'Added';
            $group_priest->deleted_at = null;
            $group_priest->save();
        }
        $group_deacon = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_DEACON,'status'=>'Added']);
        if ($request->input('is_deacon')==0) {
            $group_deacon->delete();
        } else {
            $group_deacon->contact_id = $person->id;
            $group_deacon->group_id = GROUP_ID_DEACON;
            $group_deacon->status = 'Added';
            $group_deacon->deleted_at = null;
            $group_deacon->save();
        }
        $group_pastor = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_PASTOR,'status'=>'Added']);
        if ($request->input('is_pastor')==0) {
            $group_pastor->delete();
        } else {
            $group_pastor->contact_id = $person->id;
            $group_pastor->group_id = GROUP_ID_PASTOR;
            $group_pastor->status = 'Added';
            $group_pastor->deleted_at = null;
            $group_pastor->save();
        }
        $group_jesuit = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_JESUIT,'status'=>'Added']);
        if ($request->input('is_jesuit')==0) {
            $group_jesuit->delete();
        } else {
            $group_jesuit->contact_id = $person->id;
            $group_jesuit->group_id = GROUP_ID_JESUIT;
            $group_jesuit->status = 'Added';
            $group_jesuit->deleted_at = null;
            $group_jesuit->save();
        }
        $group_provincial = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_PROVINCIAL,'status'=>'Added']);
        if ($request->input('is_provincial')==0) {
            $group_provincial->delete();
        } else {
            $group_provincial->contact_id = $person->id;
            $group_provincial->group_id = GROUP_ID_PROVINCIAL;
            $group_provincial->status = 'Added';
            $group_provincial->deleted_at = null;
            $group_provincial->save();
        }
        $group_superior = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_SUPERIOR,'status'=>'Added']);
        if ($request->input('is_superior')==0) {
            $group_superior->delete();
        } else {
            $group_superior->contact_id = $person->id;
            $group_superior->group_id = GROUP_ID_SUPERIOR;
            $group_superior->status = 'Added';
            $group_superior->deleted_at = null;
            $group_superior->save();
        }
        $group_board = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_BOARD]);
        if ($request->input('is_board')==0) {
            if (isset($group_board->id)) {
                $group_board->status='Removed';
                $group_board->save();
            }
        } else {
            $group_board->contact_id = $person->id;
            $group_board->group_id = GROUP_ID_BOARD;
            $group_board->status = 'Added';
            $group_board->deleted_at = null;
            $group_board->save();
        }
        $group_staff = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_STAFF,'status'=>'Added']);
        if ($request->input('is_staff')==0) {
            $group_staff->delete();
        } else {
            $group_staff->contact_id = $person->id;
            $group_staff->group_id = GROUP_ID_STAFF;
            $group_staff->status = 'Added';
            $group_staff->deleted_at = null;
            $group_staff->save();
        }
        $group_steward = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_STEWARD,'status'=>'Added']);
        if ($request->input('is_steward')==0) {
            $group_steward->delete();
        } else {
            $group_steward->contact_id = $person->id;
            $group_steward->group_id = GROUP_ID_STEWARD;
            $group_steward->status = 'Added';
            $group_steward->deleted_at = null;
            $group_steward->save();
        }
        $group_director = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_DIRECTOR,'status'=>'Added']);
        if ($request->input('is_director')==0) {
            $group_director->delete();
        } else {
            $group_director->contact_id = $person->id;
            $group_director->group_id = GROUP_ID_DIRECTOR;
            $group_director->status = 'Added';
            $group_director->deleted_at = null;
            $group_director->save();
        }
        $group_innkeeper = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_INNKEEPER,'status'=>'Added']);
        if ($request->input('is_innkeeper')==0) {
            $group_innkeeper->delete();
        } else {
            $group_innkeeper->contact_id = $person->id;
            $group_innkeeper->group_id = GROUP_ID_INNKEEPER;
            $group_innkeeper->status = 'Added';
            $group_innkeeper->deleted_at = null;
            $group_innkeeper->save();
        }
        $group_assistant = \montserrat\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id,'group_id'=>GROUP_ID_ASSISTANT,'status'=>'Added']);
        if ($request->input('is_assistant')==0) {
            $group_assistant->delete();
        } else {
            $group_assistant->contact_id = $person->id;
            $group_assistant->group_id = GROUP_ID_ASSISTANT;
            $group_assistant->status = 'Added';
            $group_assistant->deleted_at = null;
            $group_assistant->save();
        }
        
        return Redirect::action('PersonsController@show', $person->id);//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-contact');
        
        // TODO: consider creating a restore/{id} or undelete/{id}
        
        //delete existing groups and relationships when deleting user
        \montserrat\Relationship::whereContactIdA($id)->delete();
        \montserrat\Relationship::whereContactIdB($id)->delete();
        \montserrat\GroupContact::whereContactId($id)->delete();
        //delete address, email, phone, website, emergency contact, notes for deleted users
        \montserrat\Address::whereContactId($id)->delete();
        \montserrat\Email::whereContactId($id)->delete();
        \montserrat\Phone::whereContactId($id)->delete();
        \montserrat\Website::whereContactId($id)->delete();
        \montserrat\EmergencyContact::whereContactId($id)->delete();
        \montserrat\Note::whereContactId($id)->delete();
        \montserrat\Touchpoint::wherePersonId($id)->delete();
        //delete registrations
        \montserrat\Registration::whereContactId($id)->delete();
        \montserrat\Contact::destroy($id);
        
        return Redirect::action('PersonsController@index');
    }
    public function merge_destroy($id, $return_id)
    {
        // TODO: consider creating a restore/{id} or undelete/{id}
        
        //delete existing groups and relationships when deleting user
        \montserrat\Relationship::whereContactIdA($id)->delete();
        \montserrat\Relationship::whereContactIdB($id)->delete();
        \montserrat\GroupContact::whereContactId($id)->delete();
        //delete address, email, phone, website, emergency contact, notes for deleted users
        \montserrat\Address::whereContactId($id)->delete();
        \montserrat\Email::whereContactId($id)->delete();
        \montserrat\Phone::whereContactId($id)->delete();
        \montserrat\Website::whereContactId($id)->delete();
        \montserrat\EmergencyContact::whereContactId($id)->delete();
        \montserrat\Note::whereContactId($id)->delete();
        \montserrat\Touchpoint::wherePersonId($id)->delete();
        //delete registrations
        \montserrat\Registration::whereContactId($id)->delete();
        \montserrat\Contact::destroy($id);
        
        return Redirect::action('PersonsController@merge', $return_id);
    }
    
    public function assistants()
    {
        return $this->role(GROUP_ID_ASSISTANT);
    }
    public function bishops()
    {
        return $this->role(GROUP_ID_BISHOP);
    }

    public function boardmembers()
    {
        return $this->role(GROUP_ID_BOARD);
    }
    public function captains()
    {
        return $this->role(GROUP_ID_CAPTAIN);
    }
    public function catholics()
    {
        $role['name'] = 'Catholics';
        $role['field'] = 'is_catholic';
        return $this->role($role);
    }
    
    public function deacons()
    {
        return $this->role(GROUP_ID_DEACON);
    }
    public function deceased()
    {
        //
        $role['name'] = 'Deceased';
        $role['field'] = 'is_deceased';
        return $this->role($role);
    }

    public function directors()
    {
        return $this->role(GROUP_ID_DIRECTOR);
    }
    public function donors()
    {
        //
        $role['name'] = 'Donors';
        $role['field'] = 'is_donor';
        return $this->role($role);
    }
    public function staff()
    {
        return $this->role(GROUP_ID_STAFF);
    }
    public function formerboard()
    {
        //
        $role['name'] = 'Former Board Members';
        $role['field'] = 'is_formerboard';
        return $this->role($role);
    }
    public function innkeepers()
    {
        return $this->role(GROUP_ID_INNKEEPER);
    }
    public function jesuits()
    {
        return $this->role(GROUP_ID_JESUIT);
    }
    public function pastors()
    {
        return $this->role(GROUP_ID_PASTOR);
    }
    public function priests()
    {
        return $this->role(GROUP_ID_PRIEST);
    }
    public function provincials()
    {
        return $this->role(GROUP_ID_PROVINCIAL);
    }
    public function retreatants()
    {
//relationship (not a group)
        return $this->role($role);
    }
    public function superiors()
    {
        return $this->role(GROUP_ID_SUPERIOR);
    }
    public function stewards()
    {
        return $this->role(GROUP_ID_STEWARD);
    }
    
        
    public function volunteers()
    {
        return $this->role(GROUP_ID_VOLUNTEER);
    }
    
    public function role($group_id)
    {
        $this->authorize('show-contact');
        
        $persons = \montserrat\Contact::with('groups', 'address_primary', 'captain_events')->whereHas('groups', function ($query) use ($group_id) {
            $query->where('group_id', '=', $group_id)->whereStatus('Added');
        })->orderBy('sort_name')->get();
        
        $group = \montserrat\Group::findOrFail($group_id);
        $role['group_id'] = $group->id;
        $role['name']= $group->name;
        $role['email_link']= "";
        
        $email_list = "";
        foreach ($persons as $person) {
            if (!empty($person->email_primary_text)) {
                $email_list .= addslashes($person->display_name). ' <'.$person->email_primary_text.'>,';
            }
            
            if (!empty($email_list)) {
                $role['email_link'] = "<a href=\"mailto:?bcc=".htmlspecialchars($email_list, ENT_QUOTES)."\">E-mail ".$group->name." Group</a>";
            } else {
                $role['email_link'] = null;
            }
        }
        return view('persons.role', compact('persons', 'role'));   //
    }
    
    public function save_relationship($field, $contact_id_a, $contact_id_b, $relationship_type)
    {
        $this->authorize('update-contact');
        
        if ($request->input($field)>0) {
            $relationship = new \montserrat\Relationship;
                $relationship->contact_id_a = $contact_id_a;
                $relationship->contact_id_b = $contact_id_b;
                $relationship->relationship_type_id = $relationship_type;
                $relationship->is_active = 1;
            $relationship->save();
        }
    }
    public function duplicates()
    {
        $this->authorize('update-contact');
        
        $duplicates = \montserrat\Contact::whereIn('id', function ($query) {
            $query->select('id')->from('contact')->groupBy('sort_name')->whereDeletedAt(null)->havingRaw('count(*)>1');
        })->orderBy('sort_name')->paginate(100);
        //dd($duplicates);
        return view('persons.duplicates', compact('duplicates'));
    }
    public function merge($contact_id, $merge_id = null)
    {
        $this->authorize('update-contact');
        
        $contact = \montserrat\Contact::findOrFail($contact_id);
        $similar = \montserrat\Contact::whereSortName($contact->sort_name)->get();
        
        $duplicates = $similar->keyBy('id');
        $duplicates->forget($contact->id);
        
        //if there are no duplicates for the user go back to duplicates list
        if (!$duplicates->count()) {
            return Redirect::action('PersonsController@duplicates');
        }
        
        if (!empty($merge_id)) {
            $merge = \montserrat\Contact::findOrFail($merge_id);
            //dd($merge);
            if ((empty($contact->prefix_id)) && (!empty($merge->prefix_id))) {
                $contact->prefix_id = $merge->prefix_id;
            }
            if (empty($contact->first_name) && !empty($merge->first_name)) {
                $contact->first_name = $merge->first_name;
            }
            if (empty($contact->nick_name) && !empty($merge->nick_name)) {
                $contact->nick_name = $merge->nick_name;
            }
            if (empty($contact->middle_name) && !empty($merge->middle_name)) {
                $contact->middle_name = $merge->middle_name;
            }
            if (empty($contact->last_name) && !empty($merge->last_name)) {
                $contact->last_name = $merge->last_name;
            }
            if (empty($contact->organization_name) && !empty($merge->organization_name)) {
                $contact->organization_name = $merge->organization_name;
            }
            if (empty($contact->suffix_id) && !empty($merge->suffix_id)) {
                $contact->suffix_id = $merge->suffix_id;
            }
            if (empty($contact->gender_id) && !empty($merge->gender_id)) {
                $contact->gender_id = $merge->gender_id;
            }
            if (empty($contact->birth_date) && !empty($merge->birth_date)) {
                $contact->birth_date = $merge->birth_date;
            }
            if (empty($contact->religion_id) && !empty($merge->religion_id)) {
                $contact->religion_id = $merge->religion_id;
            }
            if (empty($contact->occupation_id) && !empty($merge->occupation_id)) {
                $contact->occupation_id = $merge->occupation_id;
            }
            if (empty($contact->ethnicity_id) && !empty($merge->ethnicity_id)) {
                $contact->ethnicity_id = $merge->ethnicity_id;
            }
            $contact->save();
            
            //addresses
            if (null === $contact->address_primary) {
                $contact->address_primary = new \montserrat\Address;
                $contact->address_primary->contact_id = $contact->id;
                $contact->address_primary->is_primary = 1;
            }
            if ((empty($contact->address_primary->street_address)) && (!empty($merge->address_primary->street_address))) {
                $contact->address_primary->street_address = $merge->address_primary->street_address;
            }
            if ((empty($contact->address_primary->supplemental_address)) && (!empty($merge->address_primary->supplemental_address))) {
                $contact->address_primary->supplemental_address = $merge->address_primary->supplemental_address;
            }
            if ((empty($contact->address_primary->city)) && (!empty($merge->address_primary->city))) {
                $contact->address_primary->city = $merge->address_primary->city;
            }
            if ((empty($contact->address_primary->state_province_id)) && (!empty($merge->address_primary->state_province_id))) {
                $contact->address_primary->state_province_id = $merge->address_primary->state_province_id;
            }
            if ((empty($contact->address_primary->postal_code)) && (!empty($merge->address_primary->postal_code))) {
                $contact->address_primary->postal_code = $merge->address_primary->postal_code;
            }
            if ((empty($contact->address_primary->country_code)) && (!empty($merge->address_primary->country_code))) {
                $contact->address_primary->country_code = $merge->address_primary->country_code;
            }
            $contact->address_primary->save();
            
            //emergency_contact_info
            if (null === $contact->emergency_contact) {
                $contact->emergency_contact = new \montserrat\EmergencyContact;
                $contact->emergency_contact->contact_id = $contact->id;
            }
         
            if ((empty($contact->emergency_contact->name)) && (!empty($merge->emergency_contact->name))) {
                $contact->emergency_contact->name = $merge->emergency_contact->name;
            }
            if ((empty($contact->emergency_contact->relationship)) && (!empty($merge->emergency_contact->relationship))) {
                $contact->emergency_contact->relationship = $merge->emergency_contact->relationship;
            }
            if ((empty($contact->emergency_contact->phone)) && (!empty($merge->emergency_contact->phone))) {
                $contact->emergency_contact->phone = $merge->emergency_contact->phone;
            }
            if ((empty($contact->emergency_contact->phone_alternate)) && (!empty($merge->emergency_contact->phone_alternate))) {
                $contact->emergency_contact->phone_alternate = $merge->emergency_contact->phone_alternate;
            }
            $contact->emergency_contact->save();
            
            //emails
            foreach ($merge->emails as $email) {
                $contact_email = \montserrat\Email::firstOrNew(['contact_id' => $contact->id, 'location_type_id' => $email->location_type_id]);
                $contact_email->contact_id = $contact->id;
                $contact_email->location_type_id = $email->location_type_id;
                $contact_email->is_primary = $email->is_primary;
                //only create or overwrite if the current email address for the location is empty
                if (empty($contact_email->email)) {
                    $contact_email->email = $email->email;
                    $contact_email->save();
                }
            }
            
            //phones
            foreach ($merge->phones as $phone) {
                $contact_phone = \montserrat\Phone::firstOrNew(['contact_id' => $contact->id, "location_type_id" => $phone->location_type_id, "phone_type" => $phone->phone_type]);
                $contact_phone->contact_id = $contact->id;
                $contact_phone->location_type_id = $phone->location_type_id;
                $contact_phone->phone_type = $phone->phone_type;
                $contact_phone->is_primary = $phone->is_primary;
                //only create or overwrite if the current email address for the location is empty
                if (empty($contact_phone->phone)) {
                    $contact_phone->phone = $phone->phone;
                    $contact_phone->save();
                }
            }
            
            //notes - move all from merge to contact
            foreach ($merge->notes as $note) {
                $note->entity_id = $contact_id;
                $note->save();
            }
            //groups - move all from merge to contact
            foreach ($merge->groups as $group) {
                $group_exist = \montserrat\GroupContact::whereContactId($contact_id)->whereGroupId($group->group_id)->first();
                if (!isset($group_exist)) {
                    $group->contact_id = $contact_id;
                    $group->save();
                }
            }
            //relationships
            foreach ($merge->a_relationships as $a_relationship) {
                $a_relationship_exist = \montserrat\Relationship::whereContactIdA($contact_id)->whereContactIdB($a_relationship->contact_id_b)->whereRelationshipTypeId($a_relationship->relationship_type_id)->first();
                if (!isset($a_relationship_exist)) {
                    $a_relationship->contact_id_a = $contact_id;
                    $a_relationship->save();
                }
            }
            foreach ($merge->b_relationships as $b_relationship) {
                $b_relationship_exist = \montserrat\Relationship::whereContactIdB($contact_id)->whereContactIdA($b_relationship->contact_id_a)->whereRelationshipTypeId($b_relationship->relationship_type_id)->first();
                if (!isset($b_relationship_exist)) {
                    $b_relationship->contact_id_b = $contact_id;
                    $b_relationship->save();
                }
            }
            //touchpoints
            foreach ($merge->touchpoints as $touchpoint) {
                $touchpoint->person_id = $contact_id;
                $touchpoint->save();
            }
            //attachments
            foreach ($merge->attachments as $attachment) {
                $path = 'contact/' . $merge_id . '/attachments/'.$attachment->uri;
                $newpath = 'contact/' . $contact_id . '/attachments/'.$attachment->uri;
                //check for avatar.png and move appropriately otherwise move the attachment
                if ($attachment->uri == 'avatar.png') {
                    $path = 'contact/' . $merge_id . '/'.$attachment->uri;
                    $newpath = 'contact/' . $contact_id . '/'.$attachment->uri;
                }
                Storage::move($path, $newpath);
                $attachment->entity_id = $contact->id;
                $attachment->save();
            }
        }
                
        return view('persons.merge', compact('contact', 'duplicates'));
    }
}

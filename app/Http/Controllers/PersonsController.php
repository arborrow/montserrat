<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

define('CONTACT_DIOCESE_DALLAS',3);
define('CONTACT_DIOCESE_FORTWORTH',1);
define('CONTACT_DIOCESE_TYLER',2);

define('CONTACT_TYPE_INDIVIDUAL',1);
define('CONTACT_TYPE_HOUSEHOLD',2);
define('CONTACT_TYPE_ORGANIZATION',3);
define('CONTACT_TYPE_PARISH',4);
define('CONTACT_TYPE_DIOCESE',5);
define('CONTACT_TYPE_PROVINCE',6);
define('CONTACT_TYPE_COMMUNITY',7);

define('COUNTRY_ID_USA',1228);
define('STATE_PROVINCE_ID_TX',1042);

define('LOCATION_TYPE_HOME',1);
define('LOCATION_TYPE_WORK',2);
define('LOCATION_TYPE_MAIN',3);
define('LOCATION_TYPE_OTHER',4);
define('LOCATION_TYPE_BILLING',5);

define('RELATIONSHIP_TYPE_PARISHIONER',11);
define('RELATIONSHIP_TYPE_BISHOP',12);
define('RELATIONSHIP_TYPE_DIOCESE',13);
define('RELATIONSHIP_TYPE_PASTOR',14);


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
        //
//        $persons = \montserrat\Person::with('parish','addresses.state','phones','emails')->orderBy('lastname', 'asc', 'firstname','asc')->paginate(100);
        $persons = \montserrat\Contact::whereContactType(CONTACT_TYPE_INDIVIDUAL)->orderBy('sort_name', 'asc')->with('addresses.state','phones','emails','websites','parish.contact_a')->paginate(100);

        //dd($persons[1]);
        return view('persons.index',compact('persons'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parishes = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PARISH)->orderBy('organization_name', 'asc')->with('address_primary.state','diocese.contact_a')->get();
        $parish_list[0]='N/A';  
        // while probably not the most efficient way of doing this it gets me the result
        foreach($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary->city.') - '.$parish->diocese->contact_a->organization_name;
        }

        $countries = \montserrat\Country::orderBy('iso_code')->lists('iso_code','id');
        $countries->prepend('N/A',0); 
        $ethnicities = \montserrat\Ethnicity::orderBy('ethnicity')->lists('ethnicity','id');
        $ethnicities->prepend('N/A',0); 
        $genders = \montserrat\Gender::orderBy('name')->lists('name','id');
        $genders ->prepend('N/A',0); 
        $languages = \montserrat\Language::orderBy('label')->whereIsActive(1)->lists('label','id');
        $languages->prepend('N/A',0);
        $prefixes= \montserrat\Prefix::orderBy('name')->lists('name','id');
        $prefixes->prepend('N/A',0); 
        $religions = \montserrat\Religion::orderBy('name')->whereIsActive(1)->lists('name','id');
        $religions->prepend('N/A',0);
        $states = \montserrat\StateProvince::orderBy('name')->whereCountryId(1228)->lists('name','id');
        $states->prepend('N/A',0); 
        $suffixes = \montserrat\Suffix::orderBy('name')->lists('name','id');
        $suffixes->prepend('N/A',0); 
        
        return view('persons.create',compact('parish_list','ethnicities','states','countries','suffixes','prefixes','languages','genders','religions')); 
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_home' => 'email',
            'email_work' => 'email',
            'email_other' => 'email',
            'birth_date' => 'date',            
            'deceased_date' => 'date',            
            'url_main' => 'url',
            'url_work' => 'url',
            'url_facebook' => 'url',
            'url_google' => 'url',
            'url_instagram' => 'url',
            'url_linkedin' => 'url',
            'url_twitter' => 'url',
            'parish_id' => 'integer|min:0',
            'gender_id' => 'integer|min:0',
            'ethnicity_id' => 'integer|min:0',
            'religion_id' => 'integer|min:0',
        
        ]);
               
        $person = new \montserrat\Contact;
        // name info
        $person->prefix_id = $request->input('prefix_id');
        $person->first_name = $request->input('first_name');
        $person->middle_name = $request->input('middle_name');
        $person->last_name = $request->input('last_name');
        $person->suffix_id = $request->input('suffix_id');
        $person->nick_name = $request->input('nick_name');
        $person->contact_type = CONTACT_TYPE_INDIVIDUAL;
        
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
        
        // CiviCRM stores the language name rather than the language id in the contact's preferred_language field
        if (!empty($request->input('preferred_language_id'))) {
            $language = \montserrat\Language::findOrFail($request->input('preferred_language_id'));
            $person->preferred_language = $language->name;
        }
        
        $person->save();
        
        // emergency contact information - not part of CiviCRM squema 
        $emergency_contact = new \montserrat\EmergencyContact;
            $emergency_contact->contact_id=$person->id;
            $emergency_contact->name=$request->input('emergency_contact_name');
            $emergency_contact->relationship=$request->input('emergency_contact_relationship');
            $emergency_contact->phone=$request->input('emergency_contact_phone');
            $emergency_contact->phone_alternate=$request->input('emergency_contact_phone_alternate');
        $emergency_contact->save();
        
        // save parishioner relationship    
        if ($request->input('parish_id')>0) {
            $relationship_parishioner = new \montserrat\Relationship;
                $relationship_parishioner->contact_id_a = $request->input('parish_id');
                $relationship_parishioner->contact_id_b = $person->id;
                $relationship_parishioner->relationship_type_id = RELATIONSHIP_TYPE_PARISHIONER;
                $relationship_parishioner->is_active = 1;
            $relationship_parishioner->save();
        }
            
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
        
        if (empty($request->input('languages')) or in_array(0,$request->input('languages'))) {
            $person->languages()->detach();
        } else {
            $person->languages()->sync($request->input('languages'));
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

        // roles, groups, etc.
        /* $person->is_donor = $request->input('is_donor');
        $person->is_retreatant = $request->input('is_retreatant');
        $person->is_director = $request->input('is_director');
        $person->is_innkeeper = $request->input('is_innkeeper');
        $person->is_assistant = $request->input('is_assistant');
        $person->is_captain = $request->input('is_captain');
        $person->is_staff = $request->input('is_staff');
        $person->is_volunteer = $request->input('is_volunteer');
        $person->is_pastor = $request->input('is_pastor');
        $person->is_bishop = $request->input('is_bishop');
        $person->is_catholic = $request->input('is_catholic');
        $person->is_board = $request->input('is_board');
        $person->is_formerboard = $request->input('is_formerboard');
        $person->is_jesuit = $request->input('is_jesuit');
        if (empty($request->input('is_deceased'))) {
                $person->is_deceased = 0;
        } else {
            $person->is_deceased = $request->input('is_deceased');
        }
        */
        
        return Redirect::action('PersonsController@index');//

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       $person = \montserrat\Person::with('touchpoints','touchpoints.staff','websites','addresses.location','addresses.state','addresses.country','emails.location','phones','phones.location')->findOrFail($id);
       
       //dd($person);
       return view('persons.show',compact('person'));//
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $person = \montserrat\Person::with('addresses.location','emails.location','phones.location','websites')->find($id);
        //dd($person);
        $parishes = \montserrat\Parish::select(\DB::raw('CONCAT(parishes.name," (",parishes.city,"-",dioceses.name,")") as parishname'), 'parishes.id')->join('dioceses','parishes.diocese_id','=','dioceses.id')->orderBy('parishname')->lists('parishname','parishes.id');
        $parishes->prepend('N/A',0); 
        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(1228)->lists('name','id');
        $states->prepend('N/A',0); 
        $countries = \montserrat\Country::orderby('iso_code')->lists('iso_code','id');
        $countries->prepend('N/A',0); 
        $ethnicities = \montserrat\Ethnicity::orderby('ethnicity')->lists('ethnicity','ethnicity');
        
        //create defaults array for easier pre-populating of default values on edit/update blade
        // initialize defaults to avoid undefined index errors
        $defaults = array();
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
        
        foreach($person->addresses as $address) {
            $defaults[$address->location->name]['street_address'] = $address->street_address;
            $defaults[$address->location->name]['supplemental_address_1'] = $address->supplemental_address_1;
            $defaults[$address->location->name]['city'] = $address->city;
            $defaults[$address->location->name]['state_province_id'] = $address->state_province_id;
            $defaults[$address->location->name]['postal_code'] = $address->postal_code;
            $defaults[$address->location->name]['country_id'] = $address->country_id;
        }
        
        foreach($person->phones as $phone) {
            $defaults[$phone->location->name][$phone->phone_type] = $phone->phone;
        }
        
        foreach($person->emails as $email) {
            $defaults[$email->location->name]['email'] = $email->email;
        }
        
        foreach($person->websites as $website) {
            $defaults[$website->website_type]['url'] = $website->url;
        }
        //dd($defaults);
        

//dd($parishes);
        return view('persons.edit',compact('person','parishes','ethnicities','states','countries','defaults'));
    
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
        //
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email',
            'dob' => 'date',
            'url' => 'url',
            'parish_id' => 'integer|min:0',
            'gender' => 'in:Male,Female,Other,Unspecified'
        ]);
        $person = \montserrat\Person::with('addresses.location','emails.location','phones.location','websites')->findOrFail($request->input('id'));
        $person->title = $request->input('title');
        $person->firstname = $request->input('firstname');
        $person->middlename = $request->input('middlename');
        $person->lastname = $request->input('lastname');
        $person->suffix = $request->input('suffix');
        $person->nickname = $request->input('nickname');
        //emergency contact info
        $person->emergencycontactname = $request->input('emergencycontactname');
        $person->emergencycontactphone = $request->input('emergencycontactphone');
        $person->emergencycontactphone2 = $request->input('emergencycontactphone2');
        //demographic info
        $person->gender = $request->input('gender');
        $person->dob = $request->input('dob');
        $person->ethnicity = $request->input('ethnicity');
        $person->parish_id = $request->input('parish_id');
        $person->languages = $request->input('languages');
        //health info
        $person->medical = $request->input('medical');
        $person->dietary = $request->input('dietary');
        //misc info
        $person->notes = $request->input('notes');
        $person->roompreference = $request->input('roompreference');
        //group or roles info
        $person->is_donor = $request->input('is_donor');
        $person->is_retreatant = $request->input('is_retreatant');
        $person->is_director = $request->input('is_director');
        $person->is_innkeeper = $request->input('is_innkeeper');
        $person->is_assistant = $request->input('is_assistant');
        $person->is_captain = $request->input('is_captain');
        $person->is_staff = $request->input('is_staff');
        $person->is_volunteer = $request->input('is_volunteer');
        $person->is_pastor = $request->input('is_pastor');
        $person->is_bishop = $request->input('is_bishop');
        $person->is_catholic = $request->input('is_catholic');
        $person->is_board = $request->input('is_board');
        $person->is_formerboard = $request->input('is_formerboard');
        $person->is_jesuit = $request->input('is_jesuit');
        $person->is_deceased = $request->input('is_deceased');
                
        $person->save();
        
        
        $home_address= \montserrat\Address::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME]);
        //dd($home_address);
            $home_address->street_address=$request->input('address_home_address1');
            $home_address->supplemental_address_1=$request->input('address_home_address2');
            $home_address->city=$request->input('address_home_city');
            $home_address->state_province_id=$request->input('address_home_state');
            $home_address->postal_code=$request->input('address_home_zip');
            $home_address->country_id=$request->input('address_home_country');  
        $home_address->save();
         
        $work_address= \montserrat\Address::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK]);
            $work_address->street_address=$request->input('address_work_address1');
            $work_address->supplemental_address_1=$request->input('address_work_address2');
            $work_address->city=$request->input('address_work_city');
            $work_address->state_province_id=$request->input('address_work_state');
            $work_address->postal_code=$request->input('address_work_zip');
            $work_address->country_id=$request->input('address_work_country');  
        $work_address->save();
        
        $other_address= \montserrat\Address::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER]);
            $other_address->street_address=$request->input('address_other_address1');
            $other_address->supplemental_address_1=$request->input('address_other_address2');
            $other_address->city=$request->input('address_other_city');
            $other_address->state_province_id=$request->input('address_other_state');
            $other_address->postal_code=$request->input('address_other_zip');
            $other_address->country_id=$request->input('address_other_country');  
        $other_address->save();
        
        $phone_home_phone= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME,'phone_type'=>'Phone']);
            $phone_home_phone->phone=$request->input('phone_home_phone');
        $phone_home_phone->save();
        
        $phone_home_mobile= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME,'phone_type'=>'Mobile']);
            $phone_home_mobile->phone=$request->input('phone_home_mobile');
        $phone_home_mobile->save();
        
        $phone_home_fax= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME,'phone_type'=>'Fax']);
            $phone_home_fax->phone=$request->input('phone_home_fax');
        $phone_home_fax->save();
        
        $phone_work_phone= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK,'phone_type'=>'Phone']);
            $phone_work_phone->phone=$request->input('phone_work_phone');
        $phone_work_phone->save();
        
        $phone_work_mobile= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK,'phone_type'=>'Mobile']);
            $phone_work_mobile->phone=$request->input('phone_work_mobile');
        $phone_work_mobile->save();
        
        $phone_work_fax= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK,'phone_type'=>'Fax']);
            $phone_work_fax->phone=$request->input('phone_work_fax');
        $phone_work_fax->save();
        
        $phone_other_phone= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER,'phone_type'=>'Phone']);
            $phone_other_phone->phone=$request->input('phone_other_phone');
        $phone_other_phone->save();
        
        $phone_other_mobile= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER,'phone_type'=>'Mobile']);
            $phone_other_mobile->phone=$request->input('phone_other_mobile');
        $phone_other_mobile->save();
        
        $phone_other_fax= \montserrat\Phone::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER,'phone_type'=>'Fax']);
            $phone_other_fax->phone=$request->input('phone_other_fax');
        $phone_other_fax->save();
        
        $email_home = \montserrat\Email::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_HOME]);
            $email_home->email=$request->input('email_home');
        $email_home->save();
        
        $email_work= \montserrat\Email::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_WORK]);
            $email_work->email=$request->input('email_work');
        $email_work->save();
        
        $email_other = \montserrat\Email::firstOrNew(['contact_id'=>$person->id,'location_type_id'=>LOCATION_TYPE_OTHER]);
            $email_other->email=$request->input('email_other');
        $email_other->save();
        
        $url_main = \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Main']);
            $url_main->url=$request->input('url_main');
        $url_main->save();
        
        $url_work= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Work']);
            $url_work->url=$request->input('url_work');
        $url_work->save();
        
        $url_facebook= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Facebook']);
            $url_facebook->url=$request->input('url_facebook');
        $url_facebook->save();
        
        $url_google = \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Google']);
            $url_google->url=$request->input('url_google');
        $url_google->save();
        
        $url_instagram= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Instagram']);
            $url_instagram->url=$request->input('url_instagram');
        $url_instagram->save();
        
        $url_linkedin= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'LinkedIn']);
            $url_linkedin->url=$request->input('url_linkedin');
        $url_linkedin->save();
        
        $url_twitter= \montserrat\Website::firstOrNew(['contact_id'=>$person->id,'website_type'=>'Twitter']);
            $url_twitter->url=$request->input('url_twitter');
        $url_twitter->save();
        
        
        return Redirect::action('PersonsController@index');//
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        \montserrat\Person::destroy($id);
        return Redirect::action('PersonsController@index');
    
    }
    public function assistants()
    {
        //
        $role['name'] = 'Assistants';
        $role['field'] = 'is_assistant';
        return $this->role($role);
    }
    public function bishops()
    {
        //
        $role['name'] = 'Bishops';
        $role['field'] = 'is_bishop';
        return $this->role($role);
    
    }

    public function boardmembers()
    {
        //
        $role['name'] = 'Board members';
        $role['field'] = 'is_board';
        return $this->role($role);
        
    }
    public function captains()
    {
        //
        $role['name'] = 'Captains';
        $role['field'] = 'is_captain';
        return $this->role($role);
    
    }
    public function catholics()
    {
        $role['name'] = 'Catholics';
        $role['field'] = 'is_catholic';
        return $this->role($role);
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
        //
        $role['name'] = 'Retreat Directors';
        $role['field'] = 'is_director';
        return $this->role($role);
        
    }
    public function donors()
    {
        //
        $role['name'] = 'Donors';
        $role['field'] = 'is_donor';
        return $this->role($role);
    
    }
    public function employees()
    {
        $role['name'] = 'Employees';
        $role['field'] = 'is_staff';
        return $this->role($role);
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
        //
        $role['name'] = 'Retreat Innkeepers';
        $role['field'] = 'is_innkeeper';
        return $this->role($role);
    
    }
    public function jesuits()
    {
        //
        $role['name'] = 'Jesuits';
        $role['field'] = 'is_jesuit';
        return $this->role($role);
    
    }
  public function pastors()
    {
        //
        $role['name'] = 'Pastors';
        $role['field'] = 'is_pastor';
        return $this->role($role);

    }
    public function retreatants()
    {
        //
        $role['name'] = 'Retreatants';
        $role['field'] = 'is_retreatant';
        return $this->role($role);
    }
    
    public function volunteers()
    {
        //
        $role['name'] = 'Volunteers';
        $role['field'] = 'is_volunteer';
        return $this->role($role);
    }
    
    public function role($role)
    {
        //
        $persons = \montserrat\Person::orderBy('lastname', 'asc', 'firstname','asc')->where($role['field'],'1')->get();
        //dd($persons);
        return view('persons.role',compact('persons','role'));   //
    
    }
    
    
}

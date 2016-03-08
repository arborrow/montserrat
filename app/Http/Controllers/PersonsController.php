<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

define('LOCATION_TYPE_HOME',1);
define('LOCATION_TYPE_WORK',2);
define('LOCATION_TYPE_MAIN',3);
define('LOCATION_TYPE_OTHER',4);
define('LOCATION_TYPE_BILLING',5);

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
        $persons = \montserrat\Person::with('parish','addresses','addresses.state','phones','emails')->orderBy('lastname', 'asc', 'firstname','asc')->paginate(100);
        //dd($persons[3]);
        return view('persons.index',compact('persons'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$parishes= \montserrat\Parish::with('diocese')->orderby('name')->lists('name','id');
        //$parishes = \montserrat\Parish::join('dioceses', 'parishes.diocese_id', '=', 'dioceses.id')->select('parishes.name', 'parishes.id')->lists('parishes.name','parishes.id');
      
        $parishes = \montserrat\Parish::select(\DB::raw('CONCAT(parishes.name," (",parishes.city,"-",dioceses.name,")") as parishname'), 'parishes.id')->join('dioceses','parishes.diocese_id','=','dioceses.id')->orderBy('parishname')->lists('parishname','parishes.id');
        $parishes->prepend('N/A',0);  
        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(1228)->lists('name','id');
        $states->prepend('N/A',0); 
        $countries = \montserrat\Country::orderby('iso_code')->lists('iso_code','id');
        $countries->prepend('N/A',0); 
        $ethnicities = \montserrat\Ethnicity::orderby('ethnicity')->lists('ethnicity','ethnicity');
        return view('persons.create',compact('parishes','ethnicities','states','countries')); 
    
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
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'email',
            'dob' => 'date',            
            'url' => 'url',
            'parish_id' => 'integer|min:0',
            'gender' => 'in:Male,Female,Other,Unspecified'
        ]);
        
        $person = new \montserrat\Person;
        // name info
        $person->title = $request->input('title');
        $person->firstname = $request->input('firstname');
        $person->middlename = $request->input('middlename');
        $person->lastname = $request->input('lastname');
        $person->suffix = $request->input('suffix');
        $person->nickname = $request->input('nickname');
        // emergency contact info
        $person->emergencycontactname = $request->input('emergencycontactname');
        $person->emergencycontactphone = $request->input('emergencycontactphone');
        $person->emergencycontactphone2 = $request->input('emergencycontactphone2');
        // demographic info
        $person->gender = $request->input('gender');
        $person->dob = $request->input('dob');
        $person->ethnicity = $request->input('ethnicity');
        $person->parish_id = $request->input('parish_id');
        $person->languages = $request->input('languages');
        // health related info
        $person->medical = $request->input('medical');
        $person->dietary = $request->input('dietary');
        // misc
        $person->notes = $request->input('notes');
        $person->roompreference = $request->input('roompreference');
        // roles, groups, etc.
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
        if (empty($request->input('is_deceased'))) {
                $person->is_deceased = 0;
        } else {
            $person->is_deceased = $request->input('is_deceased');
        }
        
        $person->save();
        
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
            $work_address->is_primary=1;
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
            $other_address->is_primary=1;
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
       $person = \montserrat\Person::with('touchpoints','touchpoints.staff','websites','addresses','addresses.location','addresses.state','addresses.country','emails','emails.location','phones','phones.location')->findOrFail($id);
       
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
        $defaults = array();
        
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
        $person = \montserrat\Person::findOrFail($request->input('id'));
        $person->title = $request->input('title');
        $person->firstname = $request->input('firstname');
        $person->middlename = $request->input('middlename');
        $person->lastname = $request->input('lastname');
        $person->suffix = $request->input('suffix');
        $person->nickname = $request->input('nickname');
        $person->address1 = $request->input('address1');
        $person->address2 = $request->input('address2');
        $person->city = $request->input('city');
        $person->state = $request->input('state');
        $person->zip = $request->input('zip');
        $person->country = $request->input('country');
        $person->homephone = $request->input('homephone');
        $person->workphone = $request->input('workphone');
        $person->mobilephone = $request->input('mobilephone');
        $person->faxphone = $request->input('faxphone');
        $person->emergencycontactname = $request->input('emergencycontactname');
        $person->emergencycontactphone = $request->input('emergencycontactphone');
        $person->emergencycontactphone2 = $request->input('emergencycontactphone2');
        $person->url = $request->input('url');
        if (empty($person->email)) {
            $person->email = NULL;
        } else {
            $person->email = $request->input('email');
        }
        $person->gender = $request->input('gender');
        $person->dob = $request->input('dob');
        $person->ethnicity = $request->input('ethnicity');
        $person->parish_id = $request->input('parish_id');
        $person->languages = $request->input('languages');
        $person->medical = $request->input('medical');
        $person->dietary = $request->input('dietary');
        $person->notes = $request->input('notes');
        $person->roompreference = $request->input('roompreference');
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

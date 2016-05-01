<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;



class DiocesesController extends Controller
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
        // need to implement getting Bishop's name from bishop_id
        //$dioceses = \montserrat\Diocese::with('bishop')->orderBy('name', 'asc')->get();
        $dioceses = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_DIOCESE)->orderBy('organization_name', 'asc')->with('addresses.state','phones','emails','websites','bishops.contact_b','parishes.contact_a')->get();
        
        //dd($dioceses[0]["bishops"]);
        
        return view('dioceses.index',compact('dioceses'));   //
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(COUNTRY_ID_USA)->lists('name','id');
        $states->prepend('N/A',0); 
        
        $countries = \montserrat\Country::orderby('iso_code')->lists('iso_code','id');
        $countries->prepend('N/A',0); 
        
        $default['state_province_id'] = STATE_PROVINCE_ID_TX;
        $default['country_id'] = COUNTRY_ID_USA;
        
        $bishops = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {$query->where('group_id','=',GROUP_ID_BISHOP);})->lists('display_name','id');
        $bishops->prepend('N/A',0); 
        
        return view('dioceses.create',compact('bishops','states','countries','default'));  
    
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
                'organization_name' => 'required',
                'bishop_id' => 'integer|min:0',
                'email_main' => 'email',
                'website_main' => 'url'
            ]);
            
        $diocese = new \montserrat\Contact;
        $diocese->organization_name = $request->input('organization_name');
        $diocese->display_name  = $request->input('organization_name');
        $diocese->sort_name  = $request->input('organization_name');
        $diocese->contact_type = CONTACT_TYPE_ORGANIZATION;
        $diocese->subcontact_type = CONTACT_TYPE_DIOCESE;
        $diocese->save();
        
        $diocese_address= new \montserrat\Address;
            $diocese_address->contact_id=$diocese->id;
            $diocese_address->location_type_id=LOCATION_TYPE_MAIN;
            $diocese_address->is_primary=1;
            $diocese_address->street_address=$request->input('street_address');
            $diocese_address->supplemental_address_1=$request->input('supplemental_address_1');
            $diocese_address->city=$request->input('city');
            $diocese_address->state_province_id=$request->input('state_province_id');
            $diocese_address->postal_code=$request->input('postal_code');
            $diocese_address->country_id=$request->input('country_id');  
        $diocese_address->save();
        
        $diocese_main_phone= new \montserrat\Phone;
            $diocese_main_phone->contact_id=$diocese->id;
            $diocese_main_phone->location_type_id=LOCATION_TYPE_MAIN;
            $diocese_main_phone->is_primary=1;
            $diocese_main_phone->phone=$request->input('phone_main_phone');
            $diocese_main_phone->phone_type='Phone';
        $diocese_main_phone->save();
        
        $diocese_fax_phone= new \montserrat\Phone;
            $diocese_fax_phone->contact_id=$diocese->id;
            $diocese_fax_phone->location_type_id=LOCATION_TYPE_MAIN;
            $diocese_fax_phone->phone=$request->input('phone_main_fax');
            $diocese_fax_phone->phone_type='Fax';
        $diocese_fax_phone->save();
        
        $diocese_email_main = new \montserrat\Email;
            $diocese_email_main->contact_id=$diocese->id;
            $diocese_email_main->is_primary=1;
            $diocese_email_main->location_type_id=LOCATION_TYPE_MAIN;
            $diocese_email_main->email=$request->input('email_main');
        $diocese_email_main->save();
        
        $diocese_website_main = new \montserrat\Website;
            $diocese_website_main->contact_id=$diocese->id;
            $diocese_website_main->url=$request->input('website_main');
            $diocese_website_main->website_type='Main';
        $diocese_website_main->save();
        
        //TODO: add contact_id which is the id of the creator of the note
        if (!empty($request->input('note'))); {
            $diocese_note = new \montserrat\Note;
            $diocese_note->entity_table = 'contact';
            $diocese_note->entity_id = $diocese->id;
            $diocese_note->note=$request->input('note');
            $diocese_note->subject='Diocese note';
            $diocese_note->save();
        }
        
        if ($request->input('bishop_id')>0) {
            $relationship_pastor = new \montserrat\Relationship;
            $relationship_diocese->contact_id_a = $diocese->id;
            $relationship_diocese->contact_id_b = $request->input('bishop_id');
            $relationship_diocese->relationship_type_id = RELATIONSHIP_TYPE_BISHOP;
            $relationship_diocese->is_active = 1;
            $relationship_diocese->save();
        }
   
return Redirect::action('DiocesesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $diocese = \montserrat\Diocese::with('bishop')->findOrFail($id);
        $diocese = \montserrat\Contact::with('bishops.contact_b','parishes.contact_b','addresses.state','addresses.location','phones.location','emails.location','websites','notes')->findOrFail($id);
       //dd($diocese); 
       return view('dioceses.show',compact('diocese'));//
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // TODO: make create and edit bishop id multi-select with all bishops defaulting to selected on edit
        // TODO: consider making one primary bishop with multi-select for seperate auxilary bishops (new relationship)
        $diocese = \montserrat\Contact::with('bishops.contact_b','parishes.contact_b','address_primary.state','address_primary.location','phone_primary.location','phone_main_fax.location','email_primary.location','website_main','notes')->findOrFail($id);
       if (empty($diocese->bishop)) {
           $diocese->bishop_id=0;
       } else {
           $diocese->bishop_id = $diocese->bishop->contact_id_b;
       }
        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(COUNTRY_ID_USA)->lists('name','id');
        $states->prepend('N/A',0); 
        
        $countries = \montserrat\Country::orderby('iso_code')->lists('iso_code','id');
        $countries->prepend('N/A',0); 
        
        $default['state_province_id'] = STATE_PROVINCE_ID_TX;
        $default['country_id'] = COUNTRY_ID_USA;
        
        $bishops = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {$query->where('group_id','=',GROUP_ID_BISHOP);})->lists('display_name','id');
        $bishops->prepend('N/A',0); 
        //dd($diocese);
              
       return view('dioceses.edit',compact('diocese','bishops','states','countries','default'));
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
            'organization_name' => 'required',
            'bishop_id' => 'integer|min:0',
            'email_main' => 'email',
            'website_main' => 'url'
        ]);

        $diocese = \montserrat\Contact::with('bishops.contact_b','parishes.contact_b','address_primary.state','address_primary.location','phone_primary.location','phone_main_fax.location','email_primary.location','website_main','notes')->findOrFail($id);
        $diocese->organization_name = $request->input('organization_name');
        $diocese->display_name  = $request->input('organization_name');
        $diocese->sort_name  = $request->input('organization_name');
        $diocese->contact_type = CONTACT_TYPE_ORGANIZATION;
        $diocese->subcontact_type = CONTACT_TYPE_DIOCESE;
        $diocese->save();
      
        $address_primary = \montserrat\Address::findOrNew($diocese->address_primary->id);
        $address_primary->contact_id=$diocese->id;
        $address_primary->location_type_id=LOCATION_TYPE_MAIN;
        $address_primary->is_primary=1;
            
        $address_primary->street_address = $request->input('street_address');
        $address_primary->supplemental_address_1 = $request->input('supplemental_address_1');
        $address_primary->city = $request->input('city');
        $address_primary->state_province_id = $request->input('state_province_id');
        $address_primary->postal_code = $request->input('postal_code');
        $address_primary->country_id = COUNTRY_ID_USA;
        $address_primary->is_primary = 1;
        $address_primary->save();
        
        $phone_primary = \montserrat\Phone::findOrNew($diocese->phone_primary->id);
        $phone_primary->contact_id=$diocese->id;
        $phone_primary->location_type_id=LOCATION_TYPE_MAIN;
        $phone_primary->is_primary=1;
        $phone_primary->phone=$request->input('phone_main_phone');
        $phone_primary->phone_type='Phone';
        $phone_primary->save();
        
        if (empty($diocese->phone_main_fax)) {
                $phone_main_fax = new \montserrat\Phone;
            } else {
                $phone_main_fax = \montserrat\Phone::findOrNew($diocese->phone_main_fax->id);
        }
        $phone_main_fax->contact_id=$diocese->id;
        $phone_main_fax->location_type_id=LOCATION_TYPE_MAIN;
        $phone_main_fax->phone=$request->input('phone_main_fax');
        $phone_main_fax->phone_type='Fax';
        $phone_main_fax->save();
        
        $email_primary = \montserrat\Email::findOrNew($diocese->email_primary->id);
        $email_primary->contact_id=$diocese->id;
        $email_primary ->is_primary=1;
        $email_primary ->location_type_id=LOCATION_TYPE_MAIN;
        $email_primary ->email=$request->input('email_primary');
        $email_primary->save();
        
        $website_main = \montserrat\Website::findOrNew($diocese->website_main->id);
        $website_main->url = $request->input('website_main');
        $website_main->contact_id=$diocese->id;
        $website_main->website_type='Main';
        $website_main->save();
        
        
        return Redirect::action('DiocesesController@index');
        
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
         \montserrat\Contact::destroy($id);
        return Redirect::action('DiocesesController@index');
    }
}

<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;

define('RELATIONSHIP_TYPE_PARISHIONER',11);
define('RELATIONSHIP_TYPE_BISHOP',12);
define('RELATIONSHIP_TYPE_DIOCESE',13);
define('RELATIONSHIP_TYPE_PASTOR',14);

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

define('CONTACT_DIOCESE_DALLAS',3);
define('CONTACT_DIOCESE_FORTWORTH',1);
define('CONTACT_DIOCESE_TYLER',2);

define('GROUP_ID_BISHOP',4);


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
        //
        $diocese = \montserrat\Diocese::findOrFail($id);
        $bishops=  \montserrat\Person::select(\DB::raw('CONCAT(title," ",firstname," ",lastname) as fullname'), 'id')->where('is_bishop','1')->orderBy('fullname')->lists('fullname','id');
  //dd($bishops);      
       return view('dioceses.edit',compact('diocese','bishops'));
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
            'name' => 'required',
            'bishop_id' => 'integer|min:0',
            'email' => 'email',
            'webpage' => 'url'
        ]);

        $diocese = \montserrat\Diocese::findOrFail($request->input('id'));
        $diocese->bishop_id= $request->input('bishop_id');
        $diocese->name = $request->input('name');
        $diocese->address1 = $request->input('address1');
        $diocese->address2 = $request->input('address2');
        $diocese->city = $request->input('city');
        $diocese->state = $request->input('state');
        $diocese->zip = $request->input('zip');
        $diocese->phone= $request->input('phone');
        $diocese->fax = $request->input('fax');
        $diocese->email = $request->input('email');
        $diocese->webpage = $request->input('webpage');
        $diocese->notes = $request->input('notes');
        $diocese->save();

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
         \montserrat\Diocese::destroy($id);
        return Redirect::action('DiocesesController@index');
    }
}

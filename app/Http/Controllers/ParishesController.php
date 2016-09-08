<?php

namespace montserrat\Http\Controllers;

use Illuminate\Http\Request;
use montserrat\Http\Requests;
use montserrat\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;




class ParishesController extends Controller
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
        //$parishes = \montserrat\Parish::with('diocese','pastor')->orderBy('name', 'asc')->get();
        $parishes = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PARISH)->orderBy('organization_name', 'asc')->with('addresses.state','phones','emails','websites','pastor.contact_b','diocese.contact_a')->get();
        
                
        //dd($parishes[3]);
        $parishes = $parishes->sortBy(function($parish) {
            return sprintf('%-12s%s',$parish->diocese_name,$parish->organization_name);
        });
        
        //dd($parishes[214]);
        return view('parishes.index',compact('parishes'));   //
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $dioceses = \montserrat\Diocese::orderby('name')->pluck('name','id');
        $dioceses = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_DIOCESE)->orderby('organization_name')->pluck('organization_name','id');
        $pastors = \montserrat\Contact::whereHas('b_relationships', function($query) {
            $query->whereRelationshipTypeId(RELATIONSHIP_TYPE_PASTOR)->whereIsActive(1);})->orderby('sort_name')->pluck('sort_name','id');
        $pastors[0] = 'No pastor assigned';
        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(COUNTRY_ID_USA)->pluck('name','id');
        $states->prepend('N/A',0); 
        $countries = \montserrat\Country::orderby('iso_code')->pluck('iso_code','id');
        $default['state_province_id'] = STATE_PROVINCE_ID_TX;
        $default['country_id'] = COUNTRY_ID_USA;
        $countries->prepend('N/A',0); 
        
  //dd($pastors);
        //$pastors = array();
        //$pastors[0]='Not implemented yet';
        return view('parishes.create',compact('dioceses','pastors','states','countries','default'));  
    
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
                'diocese_id' => 'integer|min:0',
                'pastor_id' => 'integer|min:0',
                'parish_email_main' => 'email',
                '$parish_website_main' => 'url',
                'phone_main_phone' => 'phone',
                'phone_main_fax' => 'phone',
            ]);
        $parish = new \montserrat\Contact;
        $parish->organization_name = $request->input('organization_name');
        $parish->display_name  = $request->input('organization_name');
        $parish->sort_name  = $request->input('organization_name');
        $parish->contact_type = CONTACT_TYPE_ORGANIZATION;
        $parish->subcontact_type = CONTACT_TYPE_PARISH;
        $parish->save();
        
        $parish_address= new \montserrat\Address;
            $parish_address->contact_id=$parish->id;
            $parish_address->location_type_id=LOCATION_TYPE_MAIN;
            $parish_address->is_primary=1;
            $parish_address->street_address=$request->input('street_address');
            $parish_address->supplemental_address_1=$request->input('supplemental_address_1');
            $parish_address->city=$request->input('city');
            $parish_address->state_province_id=$request->input('state_province_id');
            $parish_address->postal_code=$request->input('postal_code');
            $parish_address->country_id=$request->input('country_id');  
        $parish_address->save();
        
        $parish_main_phone= new \montserrat\Phone;
            $parish_main_phone->contact_id=$parish->id;
            $parish_main_phone->location_type_id=LOCATION_TYPE_MAIN;
            $parish_main_phone->is_primary=1;
            $parish_main_phone->phone=$request->input('phone_main_phone');
            $parish_main_phone->phone_type='Phone';
        $parish_main_phone->save();
        
        $parish_fax_phone= new \montserrat\Phone;
            $parish_fax_phone->contact_id=$parish->id;
            $parish_fax_phone->location_type_id=LOCATION_TYPE_MAIN;
            $parish_fax_phone->phone=$request->input('phone_main_fax');
            $parish_fax_phone->phone_type='Fax';
        $parish_fax_phone->save();
        
        $parish_email_main = new \montserrat\Email;
            $parish_email_main->contact_id=$parish->id;
            $parish_email_main->is_primary=1;
            $parish_email_main->location_type_id=LOCATION_TYPE_MAIN;
            $parish_email_main->email=$request->input('email_main');
        $parish_email_main->save();
        
        $parish_website_main = new \montserrat\Website;
            $parish_website_main->contact_id=$parish->id;
            $parish_website_main->url=$request->input('website_main');
            $parish_website_main->website_type='Main';
        $parish_website_main->save();
        
        //TODO: add contact_id which is the id of the creator of the note
        if (!empty($request->input('note'))) {
            $parish_note = new \montserrat\Note;
            $parish_note->entity_table = 'contact';
            $parish_note->entity_id = $parish->id;
            $parish_note->note=$request->input('note');
            $parish_note->subject='Parish note';
            $parish_note->save();
        }
        
        if ($request->input('diocese_id')>0) {
            $relationship_diocese = new \montserrat\Relationship;
                $relationship_diocese->contact_id_a = $request->input('diocese_id');
                $relationship_diocese->contact_id_b = $parish->id;
                $relationship_diocese->relationship_type_id = RELATIONSHIP_TYPE_DIOCESE;
                $relationship_diocese->is_active = 1;
            $relationship_diocese->save();
        }
        if ($request->input('pastor_id')>0) {
            $relationship_pastor = new \montserrat\Relationship;
                $relationship_pastor->contact_id_a = $parish->id;
                $relationship_pastor->contact_id_b = $request->input('pastor_id');
                $relationship_pastor->relationship_type_id = RELATIONSHIP_TYPE_PASTOR;
                $relationship_pastor->is_active = 1;
            $relationship_pastor->save();
        }
        
return Redirect::action('ParishesController@index');
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
        $parish = \montserrat\Contact::with('pastor.contact_b','diocese.contact_a','addresses.state','addresses.location','phones.location','emails.location','websites','notes','parishioners.contact_b.address_primary.state','parishioners.contact_b.emails.location','parishioners.contact_b.phones.location','touchpoints','a_relationships.relationship_type','a_relationships.contact_b','b_relationships.relationship_type','b_relationships.contact_a','event_registrations')->findOrFail($id);
        $files = \montserrat\Attachment::whereEntity('contact')->whereEntityId($parish->id)->get();
        $relationship_types = array();
        $relationship_types["Primary Contact"] = "Primary Contact";

        return view('parishes.show',compact('parish','files','relationship_types'));//
    
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
        $dioceses = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_DIOCESE)->orderby('organization_name')->pluck('organization_name','id');
        //$pastors = \montserrat\Contact::whereHas('b_relationships', function($query) {
        //    $query->whereRelationshipTypeId(RELATIONSHIP_TYPE_PASTOR)->whereIsActive(1);})->orderby('sort_name')->pluck('sort_name','id');
        $pastors = \montserrat\Contact::whereHas('group_pastor', function($query) {
            $query->whereGroupId(GROUP_ID_PASTOR)->whereStatus('Added');})->orderby('sort_name')->pluck('sort_name','id');
        $dioceses[0] = 'No Diocese assigned';
        $pastors[0] = 'No pastor assigned';
        //dd($pastors);
        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(COUNTRY_ID_USA)->pluck('name','id');
        $states->prepend('N/A',0); 
        $countries = \montserrat\Country::orderby('iso_code')->pluck('iso_code','id');
        $default['state_province_id'] = STATE_PROVINCE_ID_TX;
        $default['country_id'] = COUNTRY_ID_USA;
        $countries->prepend('N/A',0); 
        
        $parish = \montserrat\Contact::with('pastor.contact_b','diocese.contact_a','address_primary.state','address_primary.location','phone_primary.location','phone_main_fax','email_primary.location','website_main','notes')->findOrFail($id);
        
        return view('parishes.edit',compact('parish','dioceses','pastors','states','countries','defaults'));
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
            'diocese_id' => 'integer|min:0',
            'pastor_id' => 'integer|min:0',
            'email_primary' => 'email',
            'website_main' => 'url',
            'avatar' => 'image|max:5000',
            'attachment' => 'file|mimes:pdf,doc,docx|max:10000',
            'attachment_description' => 'string|max:200',

        ]);
        $parish = \montserrat\Contact::with('pastor.contact_a','diocese.contact_a','address_primary.state','address_primary.location','phone_primary.location','phone_main_fax','email_primary.location','website_main','notes')->findOrFail($request->input('id'));
        $parish->organization_name = $request->input('organization_name');
        $parish->display_name = $request->input('organization_name');
        $parish->sort_name = $request->input('organization_name');
        $parish->save();

            if (empty($parish->diocese)) {
                $diocese = new \montserrat\Relationship;
            } else {
                $diocese = \montserrat\Relationship::findOrNew($parish->diocese->id);
            }
            $diocese->contact_id_b = $parish->id;
            $diocese->relationship_type_id = RELATIONSHIP_TYPE_DIOCESE;
            $diocese->is_active = 1;
            $diocese->contact_id_a = $request->input('diocese_id');
            $diocese->save();
            
            if (empty($parish->pastor)) {
                $pastor = new \montserrat\Relationship;
            } else {
                $pastor = \montserrat\Relationship::findOrNew($parish->pastor->id);
            }
            $pastor->contact_id_a = $parish->id;
            $pastor->contact_id_b = $request->input('pastor_id');
            $pastor->relationship_type_id = RELATIONSHIP_TYPE_PASTOR;
            $pastor->is_active = 1;
            $pastor->save();
            
            if (empty($parish->address_primary)) {
                $address_primary = new \montserrat\Address;
            } else {
                $address_primary = \montserrat\Address::findOrNew($parish->address_primary->id);
            }
            
            $address_primary->contact_id=$parish->id;
            $address_primary->location_type_id=LOCATION_TYPE_MAIN;
            $address_primary->is_primary=1;
            $address_primary->street_address = $request->input('street_address');
            $address_primary->supplemental_address_1 = $request->input('supplemental_address_1');
            $address_primary->city = $request->input('city');
            $address_primary->state_province_id = $request->input('state_province_id');
            $address_primary->postal_code = $request->input('postal_code');
            $address_primary->country_id=$request->input('country_id');  
            $address_primary->save();
        
            if (empty($parish->phone_primary)) {
                $phone_primary = new \montserrat\Address;
            } else {
                $phone_primary = \montserrat\Phone::findOrNew($parish->phone_primary->id);
            }
            $phone_primary->contact_id=$parish->id;
            $phone_primary->location_type_id=LOCATION_TYPE_MAIN;
            $phone_primary->is_primary=1;
            $phone_primary->phone_type='Phone';
            $phone_primary->phone = $request->input('phone_main_phone');
            $phone_primary->save();
            
            if (empty($parish->phone_main_fax)) {
                $phone_main_fax = new \montserrat\Phone;
            } else {
                $phone_main_fax = \montserrat\Phone::findOrNew($parish->phone_main_fax->id);
            }
            $phone_main_fax->contact_id=$parish->id;
            $phone_main_fax->location_type_id=LOCATION_TYPE_MAIN;
            $phone_main_fax->phone_type='Fax';
            $phone_main_fax->phone = $request->input('phone_main_fax');
            $phone_main_fax->save();
            
            
            if (empty($parish->email_primary)) {
                $email_primary= new \montserrat\Email;
            } else {
                $email_primary = \montserrat\Email::findOrNew($parish->email_primary->id);
            }
            
            $email_primary->contact_id=$parish->id;
            $email_primary->is_primary=1;
            $email_primary->location_type_id=LOCATION_TYPE_MAIN;
            $email_primary->email = $request->input('email_primary');
            $email_primary->save();
            
            if (empty($parish->website_main)) {
                $website_main = new \montserrat\Website;
            } else {
                $website_main = \montserrat\Website::findOrNew($parish->website_main->id);
            }
            $website_main->contact_id=$parish->id;
            $website_main->website_type='Main';
            $website_main->url = $request->input('website_main');
            $website_main->save();

        if (null !== $request->file('avatar')) {
            $avatar = Image::make($request->file('avatar')->getRealPath())->fit(150, 150)->orientate();
            Storage::put('contacts/'.$parish->id.'/'.'avatar.png',$avatar->stream('png'));
        }
        
        if (null !== $request->file('attachment')) {
            $attachment = new \montserrat\Attachment;
            $file = $request->file('attachment');
            $file_name = $file->getClientOriginalName();
            
            $attachment->file_type_id = FILE_TYPE_CONTACT_ATTACHMENT;
            $attachment->mime_type = $file->getClientMimeType();
            $attachment->uri = $file_name;
            $attachment->description = $request->input('attachment_description');
            $attachment->upload_date = \Carbon\Carbon::now();
            $attachment->entity = "contact";
            $attachment->entity_id = $parish->id;
            $attachment->save();
            Storage::disk('local')->put('contacts/'.$parish->id.'/attachments/'.$file_name,File::get($file));
        }
        return Redirect::action('ParishesController@index');
        
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
        return Redirect::action('ParishesController@index');
    }

    public function fortworthdiocese()
    {
        $parishes= \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PARISH)->orderBy('organization_name', 'asc')->with('addresses.state','phones','emails','websites','pastor.contact_b','diocese.contact_a')->whereHas('diocese.contact_a', function ($query) {$query->where('contact_id_a','=',CONTACT_DIOCESE_FORTWORTH);})->get();
        return view('parishes.fortworthdiocese',compact('parishes'));   //
    
    }
    public function dallasdiocese()
    {
        $parishes= \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PARISH)->orderBy('organization_name', 'asc')->with('addresses.state','phones','emails','websites','pastor.contact_b','diocese.contact_a')->whereHas('diocese.contact_a', function ($query) {$query->where('contact_id_a','=',CONTACT_DIOCESE_DALLAS);})->get();
        return view('parishes.dallasdiocese',compact('parishes'));   //
    
    }
    public function tylerdiocese()
    {
        $parishes= \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_PARISH)->orderBy('organization_name', 'asc')->with('addresses.state','phones','emails','websites','pastor.contact_b','diocese.contact_a')->whereHas('diocese.contact_a', function ($query) {$query->where('contact_id_a','=',CONTACT_DIOCESE_TYLER);})->get();
        return view('parishes.tylerdiocese',compact('parishes'));   //
    
    }
  
}

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
        $this->authorize('show-contact');
        
        $dioceses = \montserrat\Contact::whereSubcontactType(config('polanco.contact_type.diocese'))->orderBy('sort_name', 'asc')->with('addresses.state', 'phones', 'emails', 'websites', 'bishops.contact_b', 'parishes.contact_a')->get();
        
        return view('dioceses.index', compact('dioceses'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-contact');
        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);
        
        $countries = \montserrat\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);
        
        $defaults['state_province_id'] = config('polanco.state_province_id_tx');
        $defaults['country_id'] = config('polanco.country_id_usa');
        
        $bishops = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.bishop'));
        })->pluck('display_name', 'id');
        $bishops->prepend('N/A', 0);
        
        return view('dioceses.create', compact('bishops', 'states', 'countries', 'defaults'));
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
            'organization_name' => 'required',
            'bishop_id' => 'integer|min:0',
            'email_main' => 'email|nullable',
            'url_main' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\.com\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\.google\.com\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\.com\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\.com\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\.com\/.+/i|nullable',
        /*    'phone_main_phone' => 'phone|nullable',
            'phone_main_fax' => 'phone|nullable',*/
        ]);

        $diocese = new \montserrat\Contact;
        $diocese->organization_name = $request->input('organization_name');
        $diocese->display_name  = $request->input('organization_name');
        $diocese->sort_name  = $request->input('organization_name');
        $diocese->contact_type = config('polanco.contact_type.organization');
        $diocese->subcontact_type = config('polanco.contact_type.diocese');
        $diocese->save();
        
        $diocese_address= new \montserrat\Address;
            $diocese_address->contact_id=$diocese->id;
            $diocese_address->location_type_id=config('polanco.location_type.main');
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
            $diocese_main_phone->location_type_id=config('polanco.location_type.main');
            $diocese_main_phone->is_primary=1;
            $diocese_main_phone->phone=$request->input('phone_main_phone');
            $diocese_main_phone->phone_type='Phone';
        $diocese_main_phone->save();
        
        $diocese_fax_phone= new \montserrat\Phone;
            $diocese_fax_phone->contact_id=$diocese->id;
            $diocese_fax_phone->location_type_id=config('polanco.location_type.main');
            $diocese_fax_phone->phone=$request->input('phone_main_fax');
            $diocese_fax_phone->phone_type='Fax';
        $diocese_fax_phone->save();
        
        $diocese_email_main = new \montserrat\Email;
            $diocese_email_main->contact_id=$diocese->id;
            $diocese_email_main->is_primary=1;
            $diocese_email_main->location_type_id=config('polanco.location_type.main');
            $diocese_email_main->email=$request->input('email_main');
        $diocese_email_main->save();
        
        $url_main = new \montserrat\Website;
            $url_main->contact_id=$diocese->id;
            $url_main->url=$request->input('url_main');
            $url_main->website_type='Main';
        $url_main->save();
        
        $url_work= new \montserrat\Website;
            $url_work->contact_id=$diocese->id;
            $url_work->url=$request->input('url_work');
            $url_work->website_type='Work';
        $url_work->save();
        
        $url_facebook= new \montserrat\Website;
            $url_facebook->contact_id=$diocese->id;
            $url_facebook->url=$request->input('url_facebook');
            $url_facebook->website_type='Facebook';
        $url_facebook->save();
        
        $url_google = new \montserrat\Website;
            $url_google->contact_id=$diocese->id;
            $url_google->url=$request->input('url_google');
            $url_google->website_type='Google';
        $url_google->save();
        
        $url_instagram= new \montserrat\Website;
            $url_instagram->contact_id=$diocese->id;
            $url_instagram->url=$request->input('url_instagram');
            $url_instagram->website_type='Instagram';
        $url_instagram->save();
        
        $url_linkedin= new \montserrat\Website;
            $url_linkedin->contact_id=$diocese->id;
            $url_linkedin->url=$request->input('url_linkedin');
            $url_linkedin->website_type='LinkedIn';
        $url_linkedin->save();
        
        $url_twitter= new \montserrat\Website;
            $url_twitter->contact_id=$diocese->id;
            $url_twitter->url=$request->input('url_twitter');
            $url_twitter->website_type='Twitter';
        $url_twitter->save();


        //TODO: add contact_id which is the id of the creator of the note
        if (!empty($request->input('note'))) {
            ;
        } {
            $diocese_note = new \montserrat\Note;
            $diocese_note->entity_table = 'contact';
            $diocese_note->entity_id = $diocese->id;
            $diocese_note->note=$request->input('note');
            $diocese_note->subject='Diocese note';
            $diocese_note->save();
        }
        
        if ($request->input('bishop_id')>0) {
            $relationship_bishop= new \montserrat\Relationship;
            $relationship_bishop->contact_id_a = $diocese->id;
            $relationship_bishop->contact_id_b = $request->input('bishop_id');
            $relationship_bishop->relationship_type_id = config('polanco.relationship_type.bishop');
            $relationship_bishop->is_active = 1;
            $relationship_bishop->save();
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
        $this->authorize('show-contact');
        $diocese = \montserrat\Contact::with('bishops.contact_b', 'parishes.contact_b', 'addresses.state', 'addresses.location', 'phones.location', 'emails.location', 'websites', 'notes', 'a_relationships.relationship_type', 'a_relationships.contact_b', 'b_relationships.relationship_type', 'b_relationships.contact_a', 'event_registrations')->findOrFail($id);
        $files = \montserrat\Attachment::whereEntity('contact')->whereEntityId($diocese->id)->whereFileTypeId(config('polanco.file_type.contact_attachment'))->get();
        $relationship_types = [];
        $relationship_types["Primary Contact"] = "Primary Contact";
        return view('dioceses.show', compact('diocese', 'relationship_types', 'files'));//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *  // TODO: make create and edit bishop id multi-select with all bishops defaulting to selected on edit
        // TODO: consider making one primary bishop with multi-select for seperate auxilary bishops (new relationship)
     */
    public function edit($id)
    {
        $this->authorize('update-contact');
        $diocese = \montserrat\Contact::with('primary_bishop.contact_b','bishops.contact_b', 'parishes.contact_b', 'address_primary.state', 'address_primary.location', 'phone_primary.location', 'phone_main_fax.location', 'email_primary.location', 'website_main', 'notes')->findOrFail($id);
        if (empty($diocese->primary_bishop)) {
            $diocese->bishop_id=0;
        } else {
            $diocese->bishop_id = $diocese->primary_bishop->contact_id_b;
        }
        // dd($diocese->bishop_id, $diocese->bishops,$diocese->primary_bishop);
        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);
        
        $countries = \montserrat\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);
        
        $defaults['state_province_id'] = config('polanco.state_province_id_tx');
        $defaults['country_id'] = config('polanco.country_id_usa');
        
        $bishops = \montserrat\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.bishop'));
        })->pluck('display_name', 'id');
        $bishops->prepend('N/A', 0);
        //dd($diocese);
        $defaults['Main']['url']='';
        $defaults['Work']['url']='';
        $defaults['Facebook']['url']='';
        $defaults['Google']['url']='';
        $defaults['Instagram']['url']='';
        $defaults['LinkedIn']['url']='';
        $defaults['Twitter']['url']='';


        foreach ($diocese->websites as $website) {
            $defaults[$website->website_type]['url'] = $website->url;
        }
              
        return view('dioceses.edit', compact('diocese', 'bishops', 'states', 'countries', 'defaults'));
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
            'organization_name' => 'required',
            'display_name' => 'required',
            'sort_name' => 'required',
            'bishop_id' => 'integer|min:0',
            'email_main' => 'email|nullable',
            'url_main' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\.com\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\.google\.com\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\.com\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\.com\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\.com\/.+/i|nullable',
            /*'phone_main_phone' => 'phone|nullable',
            'phone_main_fax' => 'phone|nullable',*/
            'avatar' => 'image|max:5000|nullable',
            'attachment' => 'file|mimes:pdf,doc,docx|max:10000|nullable',
            'attachment_description' => 'string|max:200|nullable',

        ]);

        $diocese = \montserrat\Contact::with('bishops.contact_b', 'parishes.contact_b', 'address_primary.state', 'address_primary.location', 'phone_primary.location', 'phone_main_fax.location', 'email_primary.location', 'website_main', 'notes')->findOrFail($id);
        $diocese->organization_name = $request->input('organization_name');
        $diocese->display_name  = $request->input('display_name');
        $diocese->sort_name  = $request->input('sort_name');
        $diocese->contact_type = config('polanco.contact_type.organization');
        $diocese->subcontact_type = config('polanco.contact_type.diocese');
        $diocese->save();
      
        $address_primary = \montserrat\Address::findOrNew($diocese->address_primary->id);
        $address_primary->contact_id=$diocese->id;
        $address_primary->location_type_id=config('polanco.location_type.main');
        $address_primary->is_primary=1;
            
        $address_primary->street_address = $request->input('street_address');
        $address_primary->supplemental_address_1 = $request->input('supplemental_address_1');
        $address_primary->city = $request->input('city');
        $address_primary->state_province_id = $request->input('state_province_id');
        $address_primary->postal_code = $request->input('postal_code');
        $address_primary->country_id = config('polanco.country_id_usa');
        $address_primary->is_primary = 1;
        $address_primary->save();
        
        $phone_primary = \montserrat\Phone::findOrNew($diocese->phone_primary->id);
        $phone_primary->contact_id=$diocese->id;
        $phone_primary->location_type_id=config('polanco.location_type.main');
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
        $phone_main_fax->location_type_id=config('polanco.location_type.main');
        $phone_main_fax->phone=$request->input('phone_main_fax');
        $phone_main_fax->phone_type='Fax';
        $phone_main_fax->save();
        
        $email_primary = \montserrat\Email::findOrNew($diocese->email_primary->id);
        $email_primary->contact_id=$diocese->id;
        $email_primary ->is_primary=1;
        $email_primary ->location_type_id=config('polanco.location_type.main');
        $email_primary ->email=$request->input('email_primary');
        $email_primary->save();
        
        $url_main = \montserrat\Website::firstOrNew(['contact_id'=>$diocese->id,'website_type'=>'Main']);
            $url_main->contact_id=$diocese->id;
            $url_main->url=$request->input('url_main');
            $url_main->website_type='Main';
        $url_main->save();

        $url_work= \montserrat\Website::firstOrNew(['contact_id'=>$diocese->id,'website_type'=>'Work']);
            $url_work->contact_id=$diocese->id;
            $url_work->url=$request->input('url_work');
            $url_work->website_type='Work';
        $url_work->save();

        $url_facebook= \montserrat\Website::firstOrNew(['contact_id'=>$diocese->id,'website_type'=>'Facebook']);
            $url_facebook->contact_id=$diocese->id;
            $url_facebook->url=$request->input('url_facebook');
            $url_facebook->website_type='Facebook';
        $url_facebook->save();

        $url_google = \montserrat\Website::firstOrNew(['contact_id'=>$diocese->id,'website_type'=>'Google']);
            $url_google->contact_id=$diocese->id;
            $url_google->url=$request->input('url_google');
            $url_google->website_type='Google';
        $url_google->save();

        $url_instagram= \montserrat\Website::firstOrNew(['contact_id'=>$diocese->id,'website_type'=>'Instagram']);
            $url_instagram->contact_id=$diocese->id;
            $url_instagram->url=$request->input('url_instagram');
            $url_instagram->website_type='Instagram';
        $url_instagram->save();

        $url_linkedin= \montserrat\Website::firstOrNew(['contact_id'=>$diocese->id,'website_type'=>'LinkedIn']);
            $url_linkedin->contact_id=$diocese->id;
            $url_linkedin->url=$request->input('url_linkedin');
            $url_linkedin->website_type='LinkedIn';
        $url_linkedin->save();

            $url_twitter= \montserrat\Website::firstOrNew(['contact_id'=>$diocese->id,'website_type'=>'Twitter']);
                $url_twitter->contact_id=$diocese->id;
                $url_twitter->url=$request->input('url_twitter');
                $url_twitter->website_type='Twitter';
            $url_twitter->save();
        
        if ($request->input('bishop_id')>0) {
            $bishop_id = $request->input('bishop_id');
            $relationship_bishop = \montserrat\Relationship::firstOrNew(['contact_id_a'=>$diocese->id,'contact_id_b'=>$bishop_id,'relationship_type_id'=>config('polanco.relationship_type.bishop'),'is_active'=>1]);
            $relationship_bishop->contact_id_a = $diocese->id;
            $relationship_bishop->contact_id_b = $bishop_id;
            $relationship_bishop->relationship_type_id = config('polanco.relationship_type.bishop');
            $relationship_bishop->is_active = 1;
            $relationship_bishop->save();
        }

        if (null !== $request->file('avatar')) {
            $description = 'Avatar for '.$diocese->organization_name;
            $attachment = new AttachmentsController;
            $attachment->update_attachment($request->file('avatar'), 'contact', $diocese->id, 'avatar', $description);
        }

        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentsController;
            $attachment->update_attachment($request->file('attachment'), 'contact', $diocese->id, 'attachment', $description);
        }

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
        $this->authorize('delete-contact');
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
        return Redirect::action('DiocesesController@index');
    }
}

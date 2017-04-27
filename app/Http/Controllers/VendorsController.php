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

class VendorsController extends Controller
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
        $vendors = \montserrat\Contact::whereSubcontactType(CONTACT_TYPE_VENDOR)->orderBy('sort_name', 'asc')->with('addresses.state', 'phones', 'emails', 'websites')->get();
        return view('vendors.index', compact('vendors'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-contact');

        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(COUNTRY_ID_USA)->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $countries = \montserrat\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $defaults['state_province_id'] = STATE_PROVINCE_ID_TX;
        $defaults['country_id'] = COUNTRY_ID_USA;
        $countries->prepend('N/A', 0);
        return view('vendors.create', compact('states', 'countries', 'defaults'));
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
            'vendor_email_main' => 'email|nullable',
            'url_main' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\.com\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\.google\.com\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\.com\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\.com\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\.com\/.+/i|nullable',
            'phone_main_phone' => 'phone|nullable',
            'phone_main_fax' => 'phone|nullable',
        ]);
        
        $vendor = new \montserrat\Contact;
        $vendor->organization_name = $request->input('organization_name');
        $vendor->display_name  = $request->input('organization_name');
        $vendor->sort_name  = $request->input('organization_name');
        $vendor->contact_type = CONTACT_TYPE_ORGANIZATION;
        $vendor->subcontact_type = CONTACT_TYPE_VENDOR;
        $vendor->save();
        
        $vendor_address= new \montserrat\Address;
            $vendor_address->contact_id=$vendor->id;
            $vendor_address->location_type_id=LOCATION_TYPE_MAIN;
            $vendor_address->is_primary=1;
            $vendor_address->street_address=$request->input('street_address');
            $vendor_address->supplemental_address_1=$request->input('supplemental_address_1');
            $vendor_address->city=$request->input('city');
            $vendor_address->state_province_id=$request->input('state_province_id');
            $vendor_address->postal_code=$request->input('postal_code');
            $vendor_address->country_id=$request->input('country_id');
        $vendor_address->save();
        
        $vendor_main_phone= new \montserrat\Phone;
            $vendor_main_phone->contact_id=$vendor->id;
            $vendor_main_phone->location_type_id=LOCATION_TYPE_MAIN;
            $vendor_main_phone->is_primary=1;
            $vendor_main_phone->phone=$request->input('phone_main_phone');
            $vendor_main_phone->phone_type='Phone';
        $vendor_main_phone->save();
        
        $vendor_fax_phone= new \montserrat\Phone;
            $vendor_fax_phone->contact_id=$vendor->id;
            $vendor_fax_phone->location_type_id=LOCATION_TYPE_MAIN;
            $vendor_fax_phone->phone=$request->input('phone_main_fax');
            $vendor_fax_phone->phone_type='Fax';
        $vendor_fax_phone->save();
        
        $vendor_email_main = new \montserrat\Email;
            $vendor_email_main->contact_id=$vendor->id;
            $vendor_email_main->is_primary=1;
            $vendor_email_main->location_type_id=LOCATION_TYPE_MAIN;
            $vendor_email_main->email=$request->input('email_main');
        $vendor_email_main->save();
        
        //TODO: add contact_id which is the id of the creator of the note
        if (!empty($request->input('note'))) {
            $vendor_note = new \montserrat\Note;
            $vendor_note->entity_table = 'contact';
            $vendor_note->entity_id = $vendor->id;
            $vendor_note->note=$request->input('note');
            $vendor_note->subject='Vendor note';
            $vendor_note->save();
        }
                
        $url_main = new \montserrat\Website;
            $url_main->contact_id=$vendor->id;
            $url_main->url=$request->input('url_main');
            $url_main->website_type='Main';
        $url_main->save();
        
        $url_work= new \montserrat\Website;
            $url_work->contact_id=$vendor->id;
            $url_work->url=$request->input('url_work');
            $url_work->website_type='Work';
        $url_work->save();
        
        $url_facebook= new \montserrat\Website;
            $url_facebook->contact_id=$vendor->id;
            $url_facebook->url=$request->input('url_facebook');
            $url_facebook->website_type='Facebook';
        $url_facebook->save();
        
        $url_google = new \montserrat\Website;
            $url_google->contact_id=$vendor->id;
            $url_google->url=$request->input('url_google');
            $url_google->website_type='Google';
        $url_google->save();
        
        $url_instagram= new \montserrat\Website;
            $url_instagram->contact_id=$vendor->id;
            $url_instagram->url=$request->input('url_instagram');
            $url_instagram->website_type='Instagram';
        $url_instagram->save();
        
        $url_linkedin= new \montserrat\Website;
            $url_linkedin->contact_id=$vendor->id;
            $url_linkedin->url=$request->input('url_linkedin');
            $url_linkedin->website_type='LinkedIn';
        $url_linkedin->save();
        
        $url_twitter= new \montserrat\Website;
            $url_twitter->contact_id=$vendor->id;
            $url_twitter->url=$request->input('url_twitter');
            $url_twitter->website_type='Twitter';
        $url_twitter->save();
 
        return Redirect::action('VendorsController@index');
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
        $vendor = \montserrat\Contact::with('addresses.state', 'addresses.location', 'phones.location', 'emails.location', 'websites', 'notes', 'touchpoints')->findOrFail($id);
        $files = \montserrat\Attachment::whereEntity('contact')->whereEntityId($vendor->id)->whereFileTypeId(FILE_TYPE_CONTACT_ATTACHMENT)->get();
        $relationship_types = [];
        $relationship_types["Primary Contact"] = "Primary Contact";
        return view('vendors.show', compact('vendor', 'relationship_types', 'files'));//
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

        $states = \montserrat\StateProvince::orderby('name')->whereCountryId(COUNTRY_ID_USA)->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $countries = \montserrat\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $defaults['state_province_id'] = STATE_PROVINCE_ID_TX;
        $defaults['country_id'] = COUNTRY_ID_USA;
        $countries->prepend('N/A', 0);
                
        $defaults['Main']['url']='';
        $defaults['Work']['url']='';
        $defaults['Facebook']['url']='';
        $defaults['Google']['url']='';
        $defaults['Instagram']['url']='';
        $defaults['LinkedIn']['url']='';
        $defaults['Twitter']['url']='';

        $vendor = \montserrat\Contact::with('address_primary.state', 'address_primary.location', 'phone_primary.location', 'phone_main_fax', 'email_primary.location', 'website_main', 'notes')->findOrFail($id);
        
        foreach ($vendor->websites as $website) {
            $defaults[$website->website_type]['url'] = $website->url;
        }

        return view('vendors.edit', compact('vendor', 'states', 'countries', 'defaults'));
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
        $this->authorize('show-contact');
        $this->validate($request, [
            'organization_name' => 'required',
            'display_name' => 'required',
            'sort_name' => 'required',
            'email_primary' => 'email|nullable',
            'url_main' => 'url|nullable',
            'url_facebook' => 'url|regex:/facebook\.com\/.+/i|nullable',
            'url_google' => 'url|regex:/plus\.google\.com\/.+/i|nullable',
            'url_twitter' => 'url|regex:/twitter\.com\/.+/i|nullable',
            'url_instagram' => 'url|regex:/instagram\.com\/.+/i|nullable',
            'url_linkedin' => 'url|regex:/linkedin\.com\/.+/i|nullable',
            'phone_main_phone' => 'phone|nullable',
            'phone_main_fax' => 'phone|nullable',
            'avatar' => 'image|max:5000|nullable',
            'attachment' => 'file|mimes:pdf,doc,docx|max:10000|nullable',
            'attachment_description' => 'string|max:200|nullable',

        ]);
        
        $vendor = \montserrat\Contact::with('address_primary.state', 'address_primary.location', 'phone_primary.location', 'phone_main_fax', 'email_primary.location', 'website_main', 'notes')->findOrFail($request->input('id'));
        $vendor->organization_name = $request->input('organization_name');
        $vendor->display_name = $request->input('display_name');
        $vendor->sort_name = $request->input('sort_name');
        $vendor->save();

        if (empty($vendor->address_primary)) {
            $address_primary = new \montserrat\Address;
        } else {
            $address_primary = \montserrat\Address::findOrNew($vendor->address_primary->id);
        }

        $address_primary->contact_id=$vendor->id;
        $address_primary->location_type_id=LOCATION_TYPE_MAIN;
        $address_primary->is_primary=1;
        $address_primary->street_address = $request->input('street_address');
        $address_primary->supplemental_address_1 = $request->input('supplemental_address_1');
        $address_primary->city = $request->input('city');
        $address_primary->state_province_id = $request->input('state_province_id');
        $address_primary->postal_code = $request->input('postal_code');
        $address_primary->country_id=$request->input('country_id');
        $address_primary->save();
        
        if (empty($vendor->phone_primary)) {
            $phone_primary = new \montserrat\Address;
        } else {
            $phone_primary = \montserrat\Phone::findOrNew($vendor->phone_primary->id);
        }

        $phone_primary->contact_id=$vendor->id;
        $phone_primary->location_type_id=LOCATION_TYPE_MAIN;
        $phone_primary->is_primary=1;
        $phone_primary->phone_type='Phone';
        $phone_primary->phone = $request->input('phone_main_phone');
        $phone_primary->save();

        if (empty($vendor->phone_main_fax)) {
            $phone_main_fax = new \montserrat\Phone;
        } else {
            $phone_main_fax = \montserrat\Phone::findOrNew($vendor->phone_main_fax->id);
        }
        $phone_main_fax->contact_id=$vendor->id;
        $phone_main_fax->location_type_id=LOCATION_TYPE_MAIN;
        $phone_main_fax->phone_type='Fax';
        $phone_main_fax->phone = $request->input('phone_main_fax');
        $phone_main_fax->save();

        if (empty($vendor->email_primary)) {
            $email_primary= new \montserrat\Email;
        } else {
            $email_primary = \montserrat\Email::findOrNew($vendor->email_primary->id);
        }

        $email_primary->contact_id=$vendor->id;
        $email_primary->is_primary=1;
        $email_primary->location_type_id=LOCATION_TYPE_MAIN;
        $email_primary->email = $request->input('email_primary');
        $email_primary->save();
                
        if (null !== $request->file('avatar')) {
            $description = 'Avatar for '.$vendor->organization_name;
            $attachment = new AttachmentsController;
            $attachment->update_attachment($request->file('avatar'), 'contact', $vendor->id, 'avatar', $description);
        }

        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentsController;
            $attachment->update_attachment($request->file('attachment'), 'contact', $vendor->id, 'attachment', $description);
        }
                
        $url_main = \montserrat\Website::firstOrNew(['contact_id'=>$vendor->id,'website_type'=>'Main']);
            $url_main->contact_id=$vendor->id;
            $url_main->url=$request->input('url_main');
            $url_main->website_type='Main';
        $url_main->save();

        $url_work= \montserrat\Website::firstOrNew(['contact_id'=>$vendor->id,'website_type'=>'Work']);
            $url_work->contact_id=$vendor->id;
            $url_work->url=$request->input('url_work');
            $url_work->website_type='Work';
        $url_work->save();

        $url_facebook= \montserrat\Website::firstOrNew(['contact_id'=>$vendor->id,'website_type'=>'Facebook']);
            $url_facebook->contact_id=$vendor->id;
            $url_facebook->url=$request->input('url_facebook');
            $url_facebook->website_type='Facebook';
        $url_facebook->save();

        $url_google = \montserrat\Website::firstOrNew(['contact_id'=>$vendor->id,'website_type'=>'Google']);
            $url_google->contact_id=$vendor->id;
            $url_google->url=$request->input('url_google');
            $url_google->website_type='Google';
        $url_google->save();

        $url_instagram= \montserrat\Website::firstOrNew(['contact_id'=>$vendor->id,'website_type'=>'Instagram']);
            $url_instagram->contact_id=$vendor->id;
            $url_instagram->url=$request->input('url_instagram');
            $url_instagram->website_type='Instagram';
        $url_instagram->save();

        $url_linkedin= \montserrat\Website::firstOrNew(['contact_id'=>$vendor->id,'website_type'=>'LinkedIn']);
            $url_linkedin->contact_id=$vendor->id;
            $url_linkedin->url=$request->input('url_linkedin');
            $url_linkedin->website_type='LinkedIn';
        $url_linkedin->save();

        $url_twitter= \montserrat\Website::firstOrNew(['contact_id'=>$vendor->id,'website_type'=>'Twitter']);
            $url_twitter->contact_id=$vendor->id;
            $url_twitter->url=$request->input('url_twitter');
            $url_twitter->website_type='Twitter';
        $url_twitter->save();

        return Redirect::action('VendorsController@index');
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
        \montserrat\Contact::destroy($id);
        return Redirect::action('VendorsController@index');
    }
}

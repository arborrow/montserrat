<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Support\Facades\Redirect;

class VendorController extends Controller
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
        $vendors = \App\Contact::whereSubcontactType(config('polanco.contact_type.vendor'))->orderBy('sort_name', 'asc')->with('addresses.state', 'phones', 'emails', 'websites')->paginate(100);

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

        $states = \App\StateProvince::orderby('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $countries = \App\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $defaults['state_province_id'] = config('polanco.state_province_id_tx');
        $defaults['country_id'] = config('polanco.country_id_usa');
        $countries->prepend('N/A', 0);

        return view('vendors.create', compact('states', 'countries', 'defaults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVendorRequest $request)
    {
        $this->authorize('create-contact');

        $vendor = new \App\Contact;
        $vendor->organization_name = $request->input('organization_name');
        $vendor->display_name = $request->input('organization_name');
        $vendor->sort_name = $request->input('organization_name');
        $vendor->contact_type = config('polanco.contact_type.organization');
        $vendor->subcontact_type = config('polanco.contact_type.vendor');
        $vendor->save();

        $vendor_address = new \App\Address;
        $vendor_address->contact_id = $vendor->id;
        $vendor_address->location_type_id = config('polanco.location_type.main');
        $vendor_address->is_primary = 1;
        $vendor_address->street_address = $request->input('street_address');
        $vendor_address->supplemental_address_1 = $request->input('supplemental_address_1');
        $vendor_address->city = $request->input('city');
        $vendor_address->state_province_id = $request->input('state_province_id');
        $vendor_address->postal_code = $request->input('postal_code');
        $vendor_address->country_id = $request->input('country_id');
        $vendor_address->save();

        $vendor_main_phone = new \App\Phone;
        $vendor_main_phone->contact_id = $vendor->id;
        $vendor_main_phone->location_type_id = config('polanco.location_type.main');
        $vendor_main_phone->is_primary = 1;
        $vendor_main_phone->phone = $request->input('phone_main_phone');
        $vendor_main_phone->phone_type = 'Phone';
        $vendor_main_phone->save();

        $vendor_fax_phone = new \App\Phone;
        $vendor_fax_phone->contact_id = $vendor->id;
        $vendor_fax_phone->location_type_id = config('polanco.location_type.main');
        $vendor_fax_phone->phone = $request->input('phone_main_fax');
        $vendor_fax_phone->phone_type = 'Fax';
        $vendor_fax_phone->save();

        $vendor_email_main = new \App\Email;
        $vendor_email_main->contact_id = $vendor->id;
        $vendor_email_main->is_primary = 1;
        $vendor_email_main->location_type_id = config('polanco.location_type.main');
        $vendor_email_main->email = $request->input('email_main');
        $vendor_email_main->save();

        //TODO: add contact_id which is the id of the creator of the note
        if (! empty($request->input('note'))) {
            $vendor_note = new \App\Note;
            $vendor_note->entity_table = 'contact';
            $vendor_note->entity_id = $vendor->id;
            $vendor_note->note = $request->input('note');
            $vendor_note->subject = 'Vendor note';
            $vendor_note->save();
        }

        $url_main = new \App\Website;
        $url_main->contact_id = $vendor->id;
        $url_main->url = $request->input('url_main');
        $url_main->website_type = 'Main';
        $url_main->save();

        $url_work = new \App\Website;
        $url_work->contact_id = $vendor->id;
        $url_work->url = $request->input('url_work');
        $url_work->website_type = 'Work';
        $url_work->save();

        $url_facebook = new \App\Website;
        $url_facebook->contact_id = $vendor->id;
        $url_facebook->url = $request->input('url_facebook');
        $url_facebook->website_type = 'Facebook';
        $url_facebook->save();

        $url_google = new \App\Website;
        $url_google->contact_id = $vendor->id;
        $url_google->url = $request->input('url_google');
        $url_google->website_type = 'Google';
        $url_google->save();

        $url_instagram = new \App\Website;
        $url_instagram->contact_id = $vendor->id;
        $url_instagram->url = $request->input('url_instagram');
        $url_instagram->website_type = 'Instagram';
        $url_instagram->save();

        $url_linkedin = new \App\Website;
        $url_linkedin->contact_id = $vendor->id;
        $url_linkedin->url = $request->input('url_linkedin');
        $url_linkedin->website_type = 'LinkedIn';
        $url_linkedin->save();

        $url_twitter = new \App\Website;
        $url_twitter->contact_id = $vendor->id;
        $url_twitter->url = $request->input('url_twitter');
        $url_twitter->website_type = 'Twitter';
        $url_twitter->save();

        return Redirect::action('VendorController@index');
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
        $vendor = \App\Contact::with('addresses.state', 'addresses.location', 'phones.location', 'emails.location', 'websites', 'notes', 'touchpoints')->findOrFail($id);
        $files = \App\Attachment::whereEntity('contact')->whereEntityId($vendor->id)->whereFileTypeId(config('polanco.file_type.contact_attachment'))->get();
        $relationship_types = [];
        $relationship_types['Primary contact'] = 'Primary contact';

        return view('vendors.show', compact('vendor', 'relationship_types', 'files')); //
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

        $states = \App\StateProvince::orderby('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $countries = \App\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $defaults['state_province_id'] = config('polanco.state_province_id_tx');
        $defaults['country_id'] = config('polanco.country_id_usa');
        $countries->prepend('N/A', 0);

        $defaults['Main']['url'] = '';
        $defaults['Work']['url'] = '';
        $defaults['Facebook']['url'] = '';
        $defaults['Google']['url'] = '';
        $defaults['Instagram']['url'] = '';
        $defaults['LinkedIn']['url'] = '';
        $defaults['Twitter']['url'] = '';

        $vendor = \App\Contact::with('address_primary.state', 'address_primary.location', 'phone_primary.location', 'phone_main_fax', 'email_primary.location', 'website_main', 'notes')->findOrFail($id);

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
    public function update(UpdateVendorRequest $request, $id)
    {
        $this->authorize('update-contact');

        $vendor = \App\Contact::with('address_primary.state', 'address_primary.location', 'phone_primary.location', 'phone_main_fax', 'email_primary.location', 'website_main', 'notes')->findOrFail($request->input('id'));
        $vendor->organization_name = $request->input('organization_name');
        $vendor->display_name = $request->input('display_name');
        $vendor->sort_name = $request->input('sort_name');
        $vendor->save();

        if (empty($vendor->address_primary)) {
            $address_primary = new \App\Address;
        } else {
            $address_primary = \App\Address::findOrNew($vendor->address_primary->id);
        }

        $address_primary->contact_id = $vendor->id;
        $address_primary->location_type_id = config('polanco.location_type.main');
        $address_primary->is_primary = 1;
        $address_primary->street_address = $request->input('street_address');
        $address_primary->supplemental_address_1 = $request->input('supplemental_address_1');
        $address_primary->city = $request->input('city');
        $address_primary->state_province_id = $request->input('state_province_id');
        $address_primary->postal_code = $request->input('postal_code');
        $address_primary->country_id = $request->input('country_id');
        $address_primary->save();

        if (empty($vendor->phone_primary)) {
            $phone_primary = new \App\Phone;
        } else {
            $phone_primary = \App\Phone::findOrNew($vendor->phone_primary->id);
        }

        $phone_primary->contact_id = $vendor->id;
        $phone_primary->location_type_id = config('polanco.location_type.main');
        $phone_primary->is_primary = 1;
        $phone_primary->phone_type = 'Phone';
        $phone_primary->phone = $request->input('phone_main_phone');
        $phone_primary->save();

        if (empty($vendor->phone_main_fax)) {
            $phone_main_fax = new \App\Phone;
        } else {
            $phone_main_fax = \App\Phone::findOrNew($vendor->phone_main_fax->id);
        }
        $phone_main_fax->contact_id = $vendor->id;
        $phone_main_fax->location_type_id = config('polanco.location_type.main');
        $phone_main_fax->phone_type = 'Fax';
        $phone_main_fax->phone = $request->input('phone_main_fax');
        $phone_main_fax->save();

        if (empty($vendor->email_primary)) {
            $email_primary = new \App\Email;
        } else {
            $email_primary = \App\Email::findOrNew($vendor->email_primary->id);
        }

        $email_primary->contact_id = $vendor->id;
        $email_primary->is_primary = 1;
        $email_primary->location_type_id = config('polanco.location_type.main');
        $email_primary->email = $request->input('email_primary');
        $email_primary->save();

        if (null !== ($request->input('note_vendor'))) {
            $vendor_note = \App\Note::firstOrNew(['entity_table'=>'contact', 'entity_id'=>$vendor->id, 'subject'=>'Vendor note']);
            $vendor_note->entity_table = 'contact';
            $vendor_note->entity_id = $vendor->id;
            $vendor_note->note = $request->input('note_vendor');
            $vendor_note->subject = 'Vendor note';
            $vendor_note->save();
        }

        if (null !== $request->file('avatar')) {
            $description = 'Avatar for '.$vendor->organization_name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('avatar'), 'contact', $vendor->id, 'avatar', $description);
        }

        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('attachment'), 'contact', $vendor->id, 'attachment', $description);
        }

        $url_main = \App\Website::firstOrNew(['contact_id'=>$vendor->id, 'website_type'=>'Main']);
        $url_main->contact_id = $vendor->id;
        $url_main->url = $request->input('url_main');
        $url_main->website_type = 'Main';
        $url_main->save();

        $url_work = \App\Website::firstOrNew(['contact_id'=>$vendor->id, 'website_type'=>'Work']);
        $url_work->contact_id = $vendor->id;
        $url_work->url = $request->input('url_work');
        $url_work->website_type = 'Work';
        $url_work->save();

        $url_facebook = \App\Website::firstOrNew(['contact_id'=>$vendor->id, 'website_type'=>'Facebook']);
        $url_facebook->contact_id = $vendor->id;
        $url_facebook->url = $request->input('url_facebook');
        $url_facebook->website_type = 'Facebook';
        $url_facebook->save();

        $url_google = \App\Website::firstOrNew(['contact_id'=>$vendor->id, 'website_type'=>'Google']);
        $url_google->contact_id = $vendor->id;
        $url_google->url = $request->input('url_google');
        $url_google->website_type = 'Google';
        $url_google->save();

        $url_instagram = \App\Website::firstOrNew(['contact_id'=>$vendor->id, 'website_type'=>'Instagram']);
        $url_instagram->contact_id = $vendor->id;
        $url_instagram->url = $request->input('url_instagram');
        $url_instagram->website_type = 'Instagram';
        $url_instagram->save();

        $url_linkedin = \App\Website::firstOrNew(['contact_id'=>$vendor->id, 'website_type'=>'LinkedIn']);
        $url_linkedin->contact_id = $vendor->id;
        $url_linkedin->url = $request->input('url_linkedin');
        $url_linkedin->website_type = 'LinkedIn';
        $url_linkedin->save();

        $url_twitter = \App\Website::firstOrNew(['contact_id'=>$vendor->id, 'website_type'=>'Twitter']);
        $url_twitter->contact_id = $vendor->id;
        $url_twitter->url = $request->input('url_twitter');
        $url_twitter->website_type = 'Twitter';
        $url_twitter->save();

        return Redirect::action('VendorController@show', $vendor->id);
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
        \App\Relationship::whereContactIdA($id)->delete();
        \App\Relationship::whereContactIdB($id)->delete();
        \App\GroupContact::whereContactId($id)->delete();
        //delete address, email, phone, website, emergency contact, notes for deleted users
        \App\Address::whereContactId($id)->delete();
        \App\Email::whereContactId($id)->delete();
        \App\Phone::whereContactId($id)->delete();
        \App\Website::whereContactId($id)->delete();
        \App\EmergencyContact::whereContactId($id)->delete();
        \App\Note::whereEntityId($id)->whereEntityTable('contact')->whereSubject('Vendor note')->delete();
        \App\Touchpoint::wherePersonId($id)->delete();
        //delete registrations
        \App\Registration::whereContactId($id)->delete();
        // delete donations
        \App\Donation::whereContactId($id)->delete();

        \App\Contact::destroy($id);

        return Redirect::action('VendorController@index');
    }
}

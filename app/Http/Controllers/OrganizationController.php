<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use Illuminate\Support\Facades\Redirect;

class OrganizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * //TODO: subcontact_type dependent on order in database which is less than ideal really looking for where not a parish or diocese organization
     */
    public function index()
    {
        $this->authorize('show-contact');
        $organizations = \App\Models\Contact::with('addresses', 'phone_main_phone', 'email_primary', 'websites', 'subcontacttype')->organizations_generic()->orderBy('organization_name', 'asc')->paginate(25, ['*'], 'organizations');
        $subcontact_types = \App\Models\ContactType::generic()->whereIsActive(1)->orderBy('label')->pluck('id', 'label');
        //dd($subcontact_types);
        return view('organizations.index', compact('organizations', 'subcontact_types'));   //
    }

    public function index_type($subcontact_type_id)
    {
        $this->authorize('show-contact');
        $subcontact_types = \App\Models\ContactType::generic()->whereIsActive(1)->orderBy('label')->pluck('id', 'label');
        $subcontact_type = \App\Models\ContactType::findOrFail($subcontact_type_id);
        $defaults = [];
        $defaults['type'] = $subcontact_type->label;
        $organizations = \App\Models\Contact::with('addresses', 'phone_main_phone', 'email_primary', 'websites', 'subcontacttype')->organizations_generic()->whereSubcontactType($subcontact_type_id)->orderBy('organization_name', 'asc')->paginate(25, ['*'], 'organizations');

        return view('organizations.index', compact('organizations', 'subcontact_types', 'defaults'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-contact');
        $states = \App\Models\StateProvince::orderby('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);

        $countries = \App\Models\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);

        $defaults['state_province_id'] = config('polanco.state_province_id_tx');
        $defaults['country_id'] = config('polanco.country_id_usa');

        $subcontact_types = \App\Models\ContactType::whereIsReserved(false)->whereIsActive(true)->where('id', '>=', config('polanco.contact_type.province'))->pluck('label', 'id');
        $subcontact_types->prepend('N/A', 0);

        return view('organizations.create', compact('subcontact_types', 'states', 'countries', 'defaults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganizationRequest $request)
    {
        $this->authorize('create-contact');

        $organization = new \App\Models\Contact;
        $organization->organization_name = $request->input('organization_name');
        $organization->display_name = $request->input('organization_name');
        $organization->sort_name = $request->input('organization_name');
        $organization->contact_type = config('polanco.contact_type.organization');
        $organization->subcontact_type = $request->input('subcontact_type');
        $organization->save();

        $organization_address = new \App\Models\Address;
        $organization_address->contact_id = $organization->id;
        $organization_address->location_type_id = config('polanco.location_type.main');
        $organization_address->is_primary = 1;
        $organization_address->street_address = $request->input('street_address');
        $organization_address->supplemental_address_1 = $request->input('supplemental_address_1');
        $organization_address->city = $request->input('city');
        $organization_address->state_province_id = $request->input('state_province_id');
        $organization_address->postal_code = $request->input('postal_code');
        $organization_address->country_id = $request->input('country_id');
        $organization_address->save();

        $organization_main_phone = new \App\Models\Phone;
        $organization_main_phone->contact_id = $organization->id;
        $organization_main_phone->location_type_id = config('polanco.location_type.main');
        $organization_main_phone->is_primary = 1;
        $organization_main_phone->phone = $request->input('phone_main_phone');
        $organization_main_phone->phone_type = 'Phone';
        $organization_main_phone->save();

        $organization_fax_phone = new \App\Models\Phone;
        $organization_fax_phone->contact_id = $organization->id;
        $organization_fax_phone->location_type_id = config('polanco.location_type.main');
        $organization_fax_phone->phone = $request->input('phone_main_fax');
        $organization_fax_phone->phone_type = 'Fax';
        $organization_fax_phone->save();

        $organization_email_main = new \App\Models\Email;
        $organization_email_main->contact_id = $organization->id;
        $organization_email_main->is_primary = 1;
        $organization_email_main->location_type_id = config('polanco.location_type.main');
        $organization_email_main->email = $request->input('email_main');
        $organization_email_main->save();

        //TODO: add contact_id which is the id of the creator of the note
        if (! empty($request->input('note'))) {
        }

        $organization_note = new \App\Models\Note;
        $organization_note->entity_table = 'contact';
        $organization_note->entity_id = $organization->id;
        $organization_note->note = $request->input('note');
        $organization_note->subject = 'Organization Note';
        $organization_note->save();

        $url_main = new \App\Models\Website;
        $url_main->contact_id = $organization->id;
        $url_main->url = $request->input('url_main');
        $url_main->website_type = 'Main';
        $url_main->save();

        $url_work = new \App\Models\Website;
        $url_work->contact_id = $organization->id;
        $url_work->url = $request->input('url_work');
        $url_work->website_type = 'Work';
        $url_work->save();

        $url_facebook = new \App\Models\Website;
        $url_facebook->contact_id = $organization->id;
        $url_facebook->url = $request->input('url_facebook');
        $url_facebook->website_type = 'Facebook';
        $url_facebook->save();

        $url_google = new \App\Models\Website;
        $url_google->contact_id = $organization->id;
        $url_google->url = $request->input('url_google');
        $url_google->website_type = 'Google';
        $url_google->save();

        $url_instagram = new \App\Models\Website;
        $url_instagram->contact_id = $organization->id;
        $url_instagram->url = $request->input('url_instagram');
        $url_instagram->website_type = 'Instagram';
        $url_instagram->save();

        $url_linkedin = new \App\Models\Website;
        $url_linkedin->contact_id = $organization->id;
        $url_linkedin->url = $request->input('url_linkedin');
        $url_linkedin->website_type = 'LinkedIn';
        $url_linkedin->save();

        $url_twitter = new \App\Models\Website;
        $url_twitter->contact_id = $organization->id;
        $url_twitter->url = $request->input('url_twitter');
        $url_twitter->website_type = 'Twitter';
        $url_twitter->save();

        flash('Organization: <a href="'.url('/organization/'.$organization->id).'">'.$organization->organization_name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
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
        $organization = \App\Models\Contact::with('addresses.state', 'addresses.location', 'phones.location', 'emails.location', 'websites', 'notes', 'phone_main_phone.location', 'a_relationships.relationship_type', 'a_relationships.contact_b', 'b_relationships.relationship_type', 'b_relationships.contact_a', 'event_registrations')->findOrFail($id);
        $donations = \App\Models\Donation::whereContactId($id)->with('payments')->orderBy('donation_date', 'DESC')->paginate(25, ['*'], 'donations');
        $touchpoints = \App\Models\Touchpoint::wherePersonId($id)->orderBy('touched_at', 'DESC')->paginate(25, ['*'], 'touchpoints');
        $registrations = \App\Models\Registration::whereContactId($id)->orderByDesc('register_date')->paginate(25, ['*'], 'registrations');

        $files = \App\Models\Attachment::whereEntity('contact')->whereEntityId($organization->id)->whereFileTypeId(config('polanco.file_type.contact_attachment'))->get();
        $relationship_filter_types = [];
        // TODO: come back to figure how to handle
        // $relationship_filter_types['Board member'] = 'Board member';
        $relationship_filter_types['Employee'] = 'Employee';
        $relationship_filter_types['Primary contact'] = 'Primary contact';
        // TODO: come back to figure how to handle
        // $relationship_filter_types['Volunteer'] = 'Volunteer';

        return view('organizations.show', compact('organization', 'files', 'relationship_filter_types', 'donations', 'registrations', 'touchpoints')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * // TODO: make create and edit bishop id multi-select with all bishops defaulting to selected on edit
     * // TODO: consider making one primary bishop with multi-select for seperate auxilary bishops (new relationship)
     */
    public function edit($id)
    {
        $this->authorize('update-contact');
        $organization = \App\Models\Contact::with('address_primary.state', 'address_primary.location', 'phone_main_phone.location', 'phone_main_fax.location', 'email_primary.location', 'website_main', 'notes')->findOrFail($id);

        $states = \App\Models\StateProvince::orderby('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);

        $countries = \App\Models\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);

        $defaults['state_province_id'] = config('polanco.state_province_id_tx');
        $defaults['country_id'] = config('polanco.country_id_usa');

        $defaults['Main']['url'] = '';
        $defaults['Work']['url'] = '';
        $defaults['Facebook']['url'] = '';
        $defaults['Google']['url'] = '';
        $defaults['Instagram']['url'] = '';
        $defaults['LinkedIn']['url'] = '';
        $defaults['Twitter']['url'] = '';

        foreach ($organization->websites as $website) {
            $defaults[$website->website_type]['url'] = $website->url;
        }

        $subcontact_types = \App\Models\ContactType::whereIsReserved(false)->whereIsActive(true)->pluck('label', 'id');
        $subcontact_types->prepend('N/A', 0);

        //dd($organization);

        return view('organizations.edit', compact('organization', 'states', 'countries', 'defaults', 'subcontact_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrganizationRequest $request, $id)
    {
        $this->authorize('update-contact');

        $organization = \App\Models\Contact::with('address_primary.state', 'address_primary.location', 'phone_main_phone.location', 'phone_main_fax.location', 'email_primary.location', 'website_main', 'note_organization')->findOrFail($id);
        $organization->organization_name = $request->input('organization_name');
        $organization->display_name = $request->input('display_name');
        $organization->sort_name = $request->input('sort_name');
        $organization->contact_type = config('polanco.contact_type.organization');
        $organization->subcontact_type = $request->input('subcontact_type');
        $organization->save();

        if (empty($organization->address_primary)) {
            $address_primary = new \App\Models\Address;
        } else {
            $address_primary = \App\Models\Address::findOrNew($organization->address_primary->id);
        }
        $address_primary->contact_id = $organization->id;
        $address_primary->location_type_id = config('polanco.location_type.main');
        $address_primary->is_primary = 1;

        $address_primary->street_address = $request->input('street_address');
        $address_primary->supplemental_address_1 = $request->input('supplemental_address_1');
        $address_primary->city = $request->input('city');
        $address_primary->state_province_id = $request->input('state_province_id');
        $address_primary->postal_code = $request->input('postal_code');
        $address_primary->country_id = config('polanco.country_id_usa');
        $address_primary->is_primary = 1;
        $address_primary->save();
//        dd($organization->phone_main_phone);
        if (empty($organization->phone_main_phone)) {
            $phone_primary = new \App\Models\Phone;
        } else {
            $phone_primary = \App\Models\Phone::findOrNew($organization->phone_main_phone->id);
        }
        $phone_primary->contact_id = $organization->id;
        $phone_primary->location_type_id = config('polanco.location_type.main');
        $phone_primary->is_primary = 1;
        $phone_primary->phone = $request->input('phone_main_phone');
        $phone_primary->phone_type = 'Phone';
        $phone_primary->save();

        if (empty($organization->phone_main_fax)) {
            $phone_main_fax = new \App\Models\Phone;
        } else {
            $phone_main_fax = \App\Models\Phone::findOrNew($organization->phone_main_fax->id);
        }
        $phone_main_fax->contact_id = $organization->id;
        $phone_main_fax->location_type_id = config('polanco.location_type.main');
        $phone_main_fax->phone = $request->input('phone_main_fax');
        $phone_main_fax->phone_type = 'Fax';
        $phone_main_fax->save();

        if (empty($organization->email_primary)) {
            $email_primary = new \App\Models\Email;
        } else {
            $email_primary = \App\Models\Email::findOrNew($organization->email_primary->id);
        }
        $email_primary->contact_id = $organization->id;
        $email_primary->is_primary = 1;
        $email_primary->location_type_id = config('polanco.location_type.main');
        $email_primary->email = $request->input('email_primary');
        $email_primary->save();

        $organization_note = \App\Models\Note::firstOrNew(['entity_table' => 'contact', 'entity_id' => $organization->id, 'subject' => 'Organization Note']);
        $organization_note->entity_table = 'contact';
        $organization_note->entity_id = $organization->id;
        $organization_note->note = $request->input('note');
        $organization_note->subject = 'Organization Note';
        $organization_note->save();

        if (null !== $request->file('avatar')) {
            $description = 'Avatar for '.$organization->organization_name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('avatar'), 'contact', $organization->id, 'avatar', $description);
        }
        if (null !== $request->file('signature')) {
            $description = 'Signature for '.$organization->organization_name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('signature'), 'contact', $organization->id, 'signature', $description);
        }

        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('attachment'), 'contact', $organization->id, 'attachment', $description);
        }

        $url_main = \App\Models\Website::firstOrNew(['contact_id' => $organization->id, 'website_type' => 'Main']);
        $url_main->contact_id = $organization->id;
        $url_main->url = $request->input('url_main');
        $url_main->website_type = 'Main';
        $url_main->save();

        $url_work = \App\Models\Website::firstOrNew(['contact_id' => $organization->id, 'website_type' => 'Work']);
        $url_work->contact_id = $organization->id;
        $url_work->url = $request->input('url_work');
        $url_work->website_type = 'Work';
        $url_work->save();

        $url_facebook = \App\Models\Website::firstOrNew(['contact_id' => $organization->id, 'website_type' => 'Facebook']);
        $url_facebook->contact_id = $organization->id;
        $url_facebook->url = $request->input('url_facebook');
        $url_facebook->website_type = 'Facebook';
        $url_facebook->save();

        $url_google = \App\Models\Website::firstOrNew(['contact_id' => $organization->id, 'website_type' => 'Google']);
        $url_google->contact_id = $organization->id;
        $url_google->url = $request->input('url_google');
        $url_google->website_type = 'Google';
        $url_google->save();

        $url_instagram = \App\Models\Website::firstOrNew(['contact_id' => $organization->id, 'website_type' => 'Instagram']);
        $url_instagram->contact_id = $organization->id;
        $url_instagram->url = $request->input('url_instagram');
        $url_instagram->website_type = 'Instagram';
        $url_instagram->save();

        $url_linkedin = \App\Models\Website::firstOrNew(['contact_id' => $organization->id, 'website_type' => 'LinkedIn']);
        $url_linkedin->contact_id = $organization->id;
        $url_linkedin->url = $request->input('url_linkedin');
        $url_linkedin->website_type = 'LinkedIn';
        $url_linkedin->save();

        $url_twitter = \App\Models\Website::firstOrNew(['contact_id' => $organization->id, 'website_type' => 'Twitter']);
        $url_twitter->contact_id = $organization->id;
        $url_twitter->url = $request->input('url_twitter');
        $url_twitter->website_type = 'Twitter';
        $url_twitter->save();

        flash('Organization: <a href="'.url('/organization/'.$organization->id).'">'.$organization->organization_name.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $organization->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * // TODO: delete addresses, emails, webpages, and phone numbers for persons, parishes, dioceses and organizations
     */
    public function destroy($id)
    {
        $this->authorize('delete-contact');
        $organization = \App\Models\Organization::findOrFail($id);
        \App\Models\Relationship::whereContactIdA($id)->delete();
        \App\Models\Relationship::whereContactIdB($id)->delete();
        \App\Models\GroupContact::whereContactId($id)->delete();
        //delete address, email, phone, website, emergency contact, notes for deleted users
        \App\Models\Address::whereContactId($id)->delete();
        \App\Models\Email::whereContactId($id)->delete();
        \App\Models\Phone::whereContactId($id)->delete();
        \App\Models\Website::whereContactId($id)->delete();
        \App\Models\EmergencyContact::whereContactId($id)->delete();
        \App\Models\Note::whereContactId($id)->delete();
        \App\Models\Touchpoint::wherePersonId($id)->delete();
        //delete registrations
        \App\Models\Registration::whereContactId($id)->delete();
        // delete donations
        \App\Models\Donation::whereContactId($id)->delete();

        \App\Models\Organization::destroy($id);

        flash('Organization: '.$organization->organization_name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}

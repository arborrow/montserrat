<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDioceseRequest;
use App\Http\Requests\UpdateDioceseRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DioceseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('show-contact');

        $dioceses = \App\Models\Contact::whereSubcontactType(config('polanco.contact_type.diocese'))->orderBy('sort_name', 'asc')->with('addresses.state', 'phones', 'emails', 'websites', 'bishops.contact_b', 'parishes.contact_a')->paginate(25, ['*'], 'dioceses');

        // dd($dioceses);
        return view('dioceses.index', compact('dioceses'));   //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create-contact');
        $states = \App\Models\StateProvince::orderby('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);

        $countries = \App\Models\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);

        $defaults['state_province_id'] = config('polanco.state_province_id_tx');
        $defaults['country_id'] = config('polanco.country_id_usa');

        $bishops = \App\Models\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.bishop'));
        })->pluck('display_name', 'id');
        $bishops->prepend('N/A', 0);

        return view('dioceses.create', compact('bishops', 'states', 'countries', 'defaults'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDioceseRequest $request): RedirectResponse
    {
        $this->authorize('create-contact');

        $diocese = new \App\Models\Contact;
        $diocese->organization_name = $request->input('organization_name');
        $diocese->display_name = $request->input('organization_name');
        $diocese->sort_name = (empty($request->input('sort_name'))) ? $request->input('organization_name') : $request->input('sort_name');
        $diocese->contact_type = config('polanco.contact_type.organization');
        $diocese->subcontact_type = config('polanco.contact_type.diocese');
        $diocese->save();

        $diocese_address = new \App\Models\Address;
        $diocese_address->contact_id = $diocese->id;
        $diocese_address->location_type_id = config('polanco.location_type.main');
        $diocese_address->is_primary = 1;
        $diocese_address->street_address = $request->input('street_address');
        $diocese_address->supplemental_address_1 = $request->input('supplemental_address_1');
        $diocese_address->city = $request->input('city');
        $diocese_address->state_province_id = $request->input('state_province_id');
        $diocese_address->postal_code = $request->input('postal_code');
        $diocese_address->country_id = $request->input('country_id');
        $diocese_address->save();

        $diocese_main_phone = new \App\Models\Phone;
        $diocese_main_phone->contact_id = $diocese->id;
        $diocese_main_phone->location_type_id = config('polanco.location_type.main');
        $diocese_main_phone->is_primary = 1;
        $diocese_main_phone->phone = $request->input('phone_main_phone');
        $diocese_main_phone->phone_type = 'Phone';
        $diocese_main_phone->save();

        $diocese_fax_phone = new \App\Models\Phone;
        $diocese_fax_phone->contact_id = $diocese->id;
        $diocese_fax_phone->location_type_id = config('polanco.location_type.main');
        $diocese_fax_phone->phone = $request->input('phone_main_fax');
        $diocese_fax_phone->phone_type = 'Fax';
        $diocese_fax_phone->save();

        $diocese_email_main = new \App\Models\Email;
        $diocese_email_main->contact_id = $diocese->id;
        $diocese_email_main->is_primary = 1;
        $diocese_email_main->location_type_id = config('polanco.location_type.main');
        $diocese_email_main->email = $request->input('email_main');
        $diocese_email_main->save();

        $url_main = new \App\Models\Website;
        $url_main->contact_id = $diocese->id;
        $url_main->url = $request->input('url_main');
        $url_main->website_type = 'Main';
        $url_main->save();

        $url_work = new \App\Models\Website;
        $url_work->contact_id = $diocese->id;
        $url_work->url = $request->input('url_work');
        $url_work->website_type = 'Work';
        $url_work->save();

        $url_facebook = new \App\Models\Website;
        $url_facebook->contact_id = $diocese->id;
        $url_facebook->url = $request->input('url_facebook');
        $url_facebook->website_type = 'Facebook';
        $url_facebook->save();

        $url_google = new \App\Models\Website;
        $url_google->contact_id = $diocese->id;
        $url_google->url = $request->input('url_google');
        $url_google->website_type = 'Google';
        $url_google->save();

        $url_instagram = new \App\Models\Website;
        $url_instagram->contact_id = $diocese->id;
        $url_instagram->url = $request->input('url_instagram');
        $url_instagram->website_type = 'Instagram';
        $url_instagram->save();

        $url_linkedin = new \App\Models\Website;
        $url_linkedin->contact_id = $diocese->id;
        $url_linkedin->url = $request->input('url_linkedin');
        $url_linkedin->website_type = 'LinkedIn';
        $url_linkedin->save();

        $url_twitter = new \App\Models\Website;
        $url_twitter->contact_id = $diocese->id;
        $url_twitter->url = $request->input('url_twitter');
        $url_twitter->website_type = 'Twitter';
        $url_twitter->save();

        $current_user = $request->user();
        $diocese_note = \App\Models\Note::firstOrNew(['entity_id' => $diocese->id, 'entity_table' => 'contact', 'subject' => 'Diocese Note']);
        if (isset($current_user->contact_id)) {
            $diocese_note->contact_id = $current_user->contact_id;
        }
        $diocese_note->note = $request->input('diocese_note');
        $diocese_note->save();

        if ($request->input('bishop_id') > 0) {
            $relationship_bishop = new \App\Models\Relationship;
            $relationship_bishop->contact_id_a = $diocese->id;
            $relationship_bishop->contact_id_b = $request->input('bishop_id');
            $relationship_bishop->relationship_type_id = config('polanco.relationship_type.bishop');
            $relationship_bishop->is_active = 1;
            $relationship_bishop->save();
        }
        flash('Diocese: <a href="'.url('/diocese/'.$diocese->id).'">'.$diocese->organization_name.'</a> added')->success();

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->authorize('show-contact');
        $diocese = \App\Models\Contact::with('bishops.contact_b', 'parishes.contact_b', 'addresses.state', 'addresses.location', 'phones.location', 'emails.location', 'websites', 'note_diocese', 'a_relationships.relationship_type', 'a_relationships.contact_b', 'b_relationships.relationship_type', 'b_relationships.contact_a')->findOrFail($id);
        $touchpoints = \App\Models\Touchpoint::wherePersonId($id)->orderBy('touched_at', 'DESC')->paginate(25, ['*'], 'touchpoints');
        $registrations = \App\Models\Registration::whereContactId($id)->orderBy('created_at', 'DESC')->paginate(25, ['*'], 'registrations');
        $donations = \App\Models\Donation::whereContactId($id)->with('payments')->orderBy('donation_date', 'DESC')->paginate(25, ['*'], 'donations');

        $files = \App\Models\Attachment::whereEntity('contact')->whereEntityId($diocese->id)->whereFileTypeId(config('polanco.file_type.contact_attachment'))->get();
        $relationship_filter_types = [];
        $relationship_filter_types['Deacon'] = 'Deacon';
        $relationship_filter_types['Employee'] = 'Employee';
        $relationship_filter_types['Priest'] = 'Priest';
        $relationship_filter_types['Primary contact'] = 'Primary contact';
        // TODO:: come back and figure out how to make volunteer for any organization or diocese atm restricted to retreat houses by definition in the database
        // $relationship_filter_types['Volunteer'] = 'Volunteer';

        return view('dioceses.show', compact('diocese', 'relationship_filter_types', 'files', 'donations', 'registrations', 'touchpoints'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     *
     *  // TODO: make create and edit bishop id multi-select with all bishops defaulting to selected on edit
        // TODO: consider making one primary bishop with multi-select for seperate auxilary bishops (new relationship)
     */
    public function edit(int $id): View
    {
        $this->authorize('update-contact');
        $diocese = \App\Models\Contact::with('primary_bishop.contact_b', 'bishops.contact_b', 'parishes.contact_b', 'address_primary.state', 'address_primary.location', 'phone_primary.location', 'phone_main_fax.location', 'email_primary.location', 'website_main', 'note_diocese')->findOrFail($id);
        if (empty($diocese->primary_bishop)) {
            $diocese->bishop_id = 0;
        } else {
            $diocese->bishop_id = $diocese->primary_bishop->contact_id_b;
        }
        // dd($diocese->bishop_id, $diocese->bishops,$diocese->primary_bishop);
        $states = \App\Models\StateProvince::orderby('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);

        $countries = \App\Models\Country::orderby('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);

        $defaults['state_province_id'] = config('polanco.state_province_id_tx');
        $defaults['country_id'] = config('polanco.country_id_usa');

        $bishops = \App\Models\Contact::with('groups.group')->orderby('sort_name')->whereHas('groups', function ($query) {
            $query->where('group_id', '=', config('polanco.group_id.bishop'));
        })->pluck('sort_name', 'id')->toArray();

        /* ensure that a bishop  has not been removed */
        if (isset($diocese->primary_bishop->contact_id_b)) {
            if (! Arr::has($bishops, $diocese->primary_bishop->contact_id_b)) {
                $bishops[$diocese->primary_bishop->contact_id_b] = $diocese->primary_bishop->contact_b->sort_name.' (former)';
                $diocese->bishop_id = $diocese->primary_bishop->contact_id_b;
                asort($bishops);
                // dd($touchpoint->staff->sort_name.' is not currently a staff member: '.$touchpoint->staff->id, $staff);
            }
        }

        $bishops = Arr::prepend($bishops, 'N/A', 0);

        // dd($bishops);

        //dd($diocese);
        $defaults['Main']['url'] = '';
        $defaults['Work']['url'] = '';
        $defaults['Facebook']['url'] = '';
        $defaults['Google']['url'] = '';
        $defaults['Instagram']['url'] = '';
        $defaults['LinkedIn']['url'] = '';
        $defaults['Twitter']['url'] = '';

        foreach ($diocese->websites as $website) {
            $defaults[$website->website_type]['url'] = $website->url;
        }

        return view('dioceses.edit', compact('diocese', 'bishops', 'states', 'countries', 'defaults'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDioceseRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-contact');

        $diocese = \App\Models\Contact::with('bishops.contact_b', 'parishes.contact_b', 'address_primary.state', 'address_primary.location', 'phone_primary.location', 'phone_main_fax.location', 'email_primary.location', 'website_main', 'notes')->findOrFail($id);
        $diocese->organization_name = $request->input('organization_name');
        $diocese->display_name = $request->input('display_name');
        $diocese->sort_name = $request->input('sort_name');
        $diocese->contact_type = config('polanco.contact_type.organization');
        $diocese->subcontact_type = config('polanco.contact_type.diocese');
        $diocese->save();
        $bishop_id = $request->input('bishop_id');

        $address_id = isset($diocese->address_primary->id) ? $diocese->address_primary->id : 0;
        $address_primary = \App\Models\Address::findOrNew($address_id);
        $address_primary->contact_id = $diocese->id;
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

        $phone_id = isset($diocese->phone_primary->id) ? $diocese->phone_primary->id : 0;
        $phone_primary = \App\Models\Phone::findOrNew($phone_id);
        $phone_primary->contact_id = $diocese->id;
        $phone_primary->location_type_id = config('polanco.location_type.main');
        $phone_primary->is_primary = 1;
        $phone_primary->phone = $request->input('phone_main_phone');
        $phone_primary->phone_type = 'Phone';
        $phone_primary->save();

        $fax_id = isset($diocese->phone_main_fax->id) ? $diocese->phone_main_fax->id : 0;
        $phone_main_fax = \App\Models\Phone::findOrNew($fax_id);
        $phone_main_fax->contact_id = $diocese->id;
        $phone_main_fax->location_type_id = config('polanco.location_type.main');
        $phone_main_fax->phone = $request->input('phone_main_fax');
        $phone_main_fax->phone_type = 'Fax';
        $phone_main_fax->save();

        $email_id = isset($diocese->email_primary->id) ? $diocese->email_primary->id : 0;
        $email_primary = \App\Models\Email::firstOrNew(['id' => $email_id]);
        $email_primary->contact_id = $diocese->id;
        $email_primary->is_primary = 1;
        $email_primary->location_type_id = config('polanco.location_type.main');
        $email_primary->email = $request->input('email_primary');
        $email_primary->save();

        $url_main = \App\Models\Website::firstOrNew(['contact_id' => $diocese->id, 'website_type' => 'Main']);
        $url_main->contact_id = $diocese->id;
        $url_main->url = $request->input('url_main');
        $url_main->website_type = 'Main';
        $url_main->save();

        $url_work = \App\Models\Website::firstOrNew(['contact_id' => $diocese->id, 'website_type' => 'Work']);
        $url_work->contact_id = $diocese->id;
        $url_work->url = $request->input('url_work');
        $url_work->website_type = 'Work';
        $url_work->save();

        $url_facebook = \App\Models\Website::firstOrNew(['contact_id' => $diocese->id, 'website_type' => 'Facebook']);
        $url_facebook->contact_id = $diocese->id;
        $url_facebook->url = $request->input('url_facebook');
        $url_facebook->website_type = 'Facebook';
        $url_facebook->save();

        $url_google = \App\Models\Website::firstOrNew(['contact_id' => $diocese->id, 'website_type' => 'Google']);
        $url_google->contact_id = $diocese->id;
        $url_google->url = $request->input('url_google');
        $url_google->website_type = 'Google';
        $url_google->save();

        $url_instagram = \App\Models\Website::firstOrNew(['contact_id' => $diocese->id, 'website_type' => 'Instagram']);
        $url_instagram->contact_id = $diocese->id;
        $url_instagram->url = $request->input('url_instagram');
        $url_instagram->website_type = 'Instagram';
        $url_instagram->save();

        $url_linkedin = \App\Models\Website::firstOrNew(['contact_id' => $diocese->id, 'website_type' => 'LinkedIn']);
        $url_linkedin->contact_id = $diocese->id;
        $url_linkedin->url = $request->input('url_linkedin');
        $url_linkedin->website_type = 'LinkedIn';
        $url_linkedin->save();

        $url_twitter = \App\Models\Website::firstOrNew(['contact_id' => $diocese->id, 'website_type' => 'Twitter']);
        $url_twitter->contact_id = $diocese->id;
        $url_twitter->url = $request->input('url_twitter');
        $url_twitter->website_type = 'Twitter';
        $url_twitter->save();

        /* current behavior will add a bishop to a diocese
         * to remove a bishop delete the relationship in contacts
         */
        if ($request->input('bishop_id') > 0) {
            $relationship_bishop = \App\Models\Relationship::firstOrNew(['contact_id_a' => $diocese->id, 'contact_id_b' => $bishop_id, 'relationship_type_id' => config('polanco.relationship_type.bishop'), 'is_active' => 1]);
            $relationship_bishop->contact_id_a = $diocese->id;
            $relationship_bishop->contact_id_b = $bishop_id;
            $relationship_bishop->relationship_type_id = config('polanco.relationship_type.bishop');
            $relationship_bishop->is_active = 1;
            $relationship_bishop->save();
        }

        /* if unsetting a Bishop for a diocese
         * remove bishop_id from diocese record
         * remove relationship
         * save diocese
         */

        if ($request->input('bishop_id') == 0) {
            $active_bishops = \App\Models\Relationship::whereContactIdA($diocese->id)->whereRelationshipTypeId(config('polanco.relationship_type.bishop'))->whereIsActive(1)->get();
            // dd($active_bishops);
            foreach ($active_bishops as $bishop) {
                $bishop->is_active = 0;
                $bishop->save();
            }
        }

        if ($request->file('avatar') !== null) {
            $description = 'Avatar for '.$diocese->organization_name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('avatar'), 'contact', $diocese->id, 'avatar', $description);
        }

        if ($request->file('attachment') !== null) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('attachment'), 'contact', $diocese->id, 'attachment', $description);
        }

        $diocese_note = \App\Models\Note::firstOrNew(['entity_id' => $diocese->id, 'entity_table' => 'contact', 'subject' => 'Diocese Note']);
        $current_user = $request->user();
        if (isset($current_user->contact_id)) {
            $diocese_note->contact_id = $current_user->contact_id;
        }
        $diocese_note->note = $request->input('diocese_note');
        $diocese_note->save();

        flash('Diocese: <a href="'.url('/diocese/'.$diocese->id).'">'.$diocese->organization_name.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $diocese->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-contact');

        $diocese = \App\Models\Contact::findOrFail($id);
        \App\Models\Relationship::whereContactIdA($id)->delete();
        \App\Models\Relationship::whereContactIdB($id)->delete();
        \App\Models\GroupContact::whereContactId($id)->delete();
        //delete address, email, phone, website, emergency contact, notes for deleted users
        \App\Models\Address::whereContactId($id)->delete();
        \App\Models\Email::whereContactId($id)->delete();
        \App\Models\Phone::whereContactId($id)->delete();
        \App\Models\Website::whereContactId($id)->delete();
        \App\Models\EmergencyContact::whereContactId($id)->delete();
        \App\Models\Note::whereEntityId($id)->whereEntityTable('contact')->whereSubject('Diocese Note')->delete();
        \App\Models\Touchpoint::wherePersonId($id)->delete();
        //delete registrations
        \App\Models\Registration::whereContactId($id)->delete();
        // delete donations
        \App\Models\Donation::whereContactId($id)->delete();

        \App\Models\Contact::destroy($id);

        flash('Diocese: '.$diocese->organization_name.' deleted')->warning()->important();

        return Redirect::action([self::class, 'index']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PersonController extends Controller
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

        $persons = \App\Models\Contact::whereContactType(config('polanco.contact_type.individual'))->orderBy('sort_name', 'asc')->with('address_primary.state', 'phones', 'emails', 'websites', 'parish.contact_a.address_primary', 'prefix', 'suffix')->paginate(100);

        return view('persons.index', compact('persons'));   //
    }

    public function lastnames($lastname = null)
    {
        $this->authorize('show-contact');
        $persons = \App\Models\Contact::whereContactType(config('polanco.contact_type.individual'))->orderBy('sort_name', 'asc')->with('addresses.state', 'phones', 'emails', 'websites', 'parish.contact_a')->where('last_name', 'LIKE', $lastname.'%')->paginate(100);

        return view('persons.index', compact('persons'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-contact');
        $parishes = \App\Models\Contact::whereSubcontactType(config('polanco.contact_type.parish'))->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        $parish_list[0] = 'N/A';
        // while probably not the most efficient way of doing this it gets me the result
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }

        $countries = \App\Models\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);
        $ethnicities = \App\Models\Ethnicity::orderBy('ethnicity')->pluck('ethnicity', 'id');
        $ethnicities->prepend('N/A', 0);
        $genders = \App\Models\Gender::orderBy('name')->pluck('name', 'id');
        $genders->prepend('N/A', 0);
        $languages = \App\Models\Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('N/A', 0);
        $referrals = \App\Models\Referral::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $referrals->prepend('N/A', 0);
        $prefixes = \App\Models\Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('N/A', 0);
        $religions = \App\Models\Religion::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $religions->prepend('N/A', 0);
        $states = \App\Models\StateProvince::orderBy('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $suffixes = \App\Models\Suffix::orderBy('name')->pluck('name', 'id');
        $suffixes->prepend('N/A', 0);
        $occupations = \App\Models\Ppd_occupation::orderBy('name')->pluck('name', 'id');
        $occupations->prepend('N/A', 0);
        $contact_types = \App\Models\ContactType::whereIsReserved(true)->orderBy('label')->pluck('label', 'id');
        $subcontact_types = \App\Models\ContactType::whereIsReserved(false)->whereIsActive(true)->orderBy('label')->pluck('label', 'id');
        $subcontact_types->prepend('N/A', 0);
        $preferred_communication_methods = config('polanco.preferred_communication_method');

        //dd($subcontact_types);
        return view('persons.create', compact('parish_list', 'ethnicities', 'states', 'countries', 'suffixes', 'prefixes', 'languages', 'genders', 'religions', 'occupations', 'contact_types', 'subcontact_types', 'referrals', 'preferred_communication_methods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonRequest $request)
    {
        $this->authorize('create-contact');
        $person = new \App\Models\Contact;

        $person->contact_type = $request->input('contact_type');
        $person->subcontact_type = $request->input('subcontact_type');

        // name info
        $person->prefix_id = $request->input('prefix_id');
        $person->first_name = $request->input('first_name');
        $person->middle_name = $request->input('middle_name');
        $person->last_name = $request->input('last_name');
        $person->suffix_id = $request->input('suffix_id');
        $person->nick_name = $request->input('nick_name');
        $person->preferred_communication_method = $request->input('preferred_communication_method_id');

        // the sort and display names are not available on creation so that we create a default and then it can be customized or tweaked individually
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
        $person->birth_date = $request->input('birth_date');
        $person->ethnicity_id = $request->input('ethnicity_id');
        $person->religion_id = $request->input('religion_id');
        $person->occupation_id = $request->input('occupation_id');

        // communication preferences
        if (empty($request->input('do_not_mail'))) {
            $person->do_not_mail = 0;
        } else {
            $person->do_not_mail = $request->input('do_not_mail');
        }
        if (empty($request->input('do_not_email'))) {
            $person->do_not_email = 0;
        } else {
            $person->do_not_email = $request->input('do_not_email');
        }

        if (empty($request->input('do_not_phone'))) {
            $person->do_not_phone = 0;
        } else {
            $person->do_not_phone = $request->input('do_not_phone');
        }

        if (empty($request->input('do_not_sms'))) {
            $person->do_not_sms = 0;
        } else {
            $person->do_not_sms = $request->input('do_not_sms');
        }

        // CiviCRM stores the language name rather than the language id in the contact's preferred_language field
        if (! empty($request->input('preferred_language_id'))) {
            $language = \App\Models\Language::findOrFail($request->input('preferred_language_id'));
            $person->preferred_language = $language->name;
        }

        if (empty($request->input('is_deceased'))) {
            $person->is_deceased = 0;
        } else {
            $person->is_deceased = $request->input('is_deceased');
        }
        if (empty($request->input('deceased_date'))) {
            $person->deceased_date = null;
        } else {
            $person->deceased_date = $request->input('deceased_date');
        }

        $person->save();

        if (null !== $request->input('agc_household_name')) {
            $agc2019 = \App\Models\Agc2019::findOrNew($person->id);
            $agc2019->contact_id = $person->id;
            $agc2019->household_name = $request->input('agc_household_name');
            $agc2019->save();
        }

        if (null !== $request->file('avatar')) {
            $description = 'Avatar for '.$person->full_name;
            $attachment = new AttachmentController;
            $attachment->store_attachment($request->file('avatar'), 'contact', $person->id, 'avatar', $description);
        }
        // emergency contact information - not part of CiviCRM squema
        $emergency_contact = new \App\Models\EmergencyContact;
        $emergency_contact->contact_id = $person->id;
        $emergency_contact->name = $request->input('emergency_contact_name');
        $emergency_contact->relationship = $request->input('emergency_contact_relationship');
        $emergency_contact->phone = $request->input('emergency_contact_phone');
        $emergency_contact->phone_alternate = $request->input('emergency_contact_phone_alternate');
        $emergency_contact->save();

        // relationships: parishioner, donor, retreatant, volunteer, ambassador, director, innkeeper, assistant, staff, board

        // save parishioner relationship
        if ($request->input('parish_id') > 0) {
            $relationship_parishioner = new \App\Models\Relationship;
            $relationship_parishioner->contact_id_a = $request->input('parish_id');
            $relationship_parishioner->contact_id_b = $person->id;
            $relationship_parishioner->relationship_type_id = config('polanco.relationship_type.parishioner');
            $relationship_parishioner->is_active = 1;
            $relationship_parishioner->save();
        }

        // save donor relationship
        if ($request->input('is_donor') > 0) {
            $relationship_donor = new \App\Models\Relationship;
            $relationship_donor->contact_id_a = config('polanco.self.id');
            $relationship_donor->contact_id_b = $person->id;
            $relationship_donor->relationship_type_id = config('polanco.relationship_type.donor');
            $relationship_donor->is_active = 1;
            $relationship_donor->save();
        }

        // save retreatant relationship
        if ($request->input('is_retreatant') > 0) {
            $relationship_retreatant = new \App\Models\Relationship;
            $relationship_retreatant->contact_id_a = config('polanco.self.id');
            $relationship_retreatant->contact_id_b = $person->id;
            $relationship_retreatant->relationship_type_id = config('polanco.relationship_type.retreatant');
            $relationship_retreatant->is_active = 1;
            $relationship_retreatant->save();
        }

        // save volunteer relationship
        if ($request->input('is_volunteer') > 0) {
            $relationship_volunteer = new \App\Models\Relationship;
            $relationship_volunteer->contact_id_a = config('polanco.self.id');
            $relationship_volunteer->contact_id_b = $person->id;
            $relationship_volunteer->relationship_type_id = config('polanco.relationship_type.volunteer');
            $relationship_volunteer->is_active = 1;
            $relationship_volunteer->save();
            $group_volunteer = new \App\Models\GroupContact;
            $group_volunteer->group_id = config('polanco.group_id.volunteer');
            $group_volunteer->contact_id = $person->id;
            $group_volunteer->status = 'Added';
            $group_volunteer->save();
        }

        // save ambassador relationship
        if ($request->input('is_ambassador') > 0) {
            $relationship_ambassador = new \App\Models\Relationship;
            $relationship_ambassador->contact_id_a = config('polanco.self.id');
            $relationship_ambassador->contact_id_b = $person->id;
            $relationship_ambassador->relationship_type_id = config('polanco.relationship_type.ambassador');
            $relationship_ambassador->is_active = 1;
            $relationship_ambassador->save();
            $group_ambassador = new \App\Models\GroupContact;
            $group_ambassador->group_id = config('polanco.group_id.ambassador');
            $group_ambassador->contact_id = $person->id;
            $group_ambassador->status = 'Added';
            $group_ambassador->save();
        }
        // save retreat director relationship
        if ($request->input('is_director') > 0) {
            $relationship_director = new \App\Models\Relationship;
            $relationship_director->contact_id_a = config('polanco.self.id');
            $relationship_director->contact_id_b = $person->id;
            $relationship_director->relationship_type_id = config('polanco.relationship_type.retreat_director');
            $relationship_director->is_active = 1;
            $relationship_director->save();
            $group_director = new \App\Models\GroupContact;
            $group_director->group_id = config('polanco.group_id.director');
            $group_director->contact_id = $person->id;
            $group_director->status = 'Added';
            $group_director->save();
        }
        // save retreat innkeeper relationship
        if ($request->input('is_innkeeper') > 0) {
            $relationship_innkeeper = new \App\Models\Relationship;
            $relationship_innkeeper->contact_id_a = config('polanco.self.id');
            $relationship_innkeeper->contact_id_b = $person->id;
            $relationship_innkeeper->relationship_type_id = config('polanco.relationship_type.retreat_innkeeper');
            $relationship_innkeeper->is_active = 1;
            $relationship_innkeeper->save();
            $group_innkeeper = new \App\Models\GroupContact;
            $group_innkeeper->group_id = config('polanco.group_id.innkeeper');
            $group_innkeeper->contact_id = $person->id;
            $group_innkeeper->status = 'Added';
            $group_innkeeper->save();
        }
        // save retreat assistant relationship
        if ($request->input('is_assistant') > 0) {
            $relationship_assistant = new \App\Models\Relationship;
            $relationship_assistant->contact_id_a = config('polanco.self.id');
            $relationship_assistant->contact_id_b = $person->id;
            $relationship_assistant->relationship_type_id = config('polanco.relationship_type.retreat_assistant');
            $relationship_assistant->is_active = 1;
            $relationship_assistant->save();
            $group_assistant = new \App\Models\GroupContact;
            $group_assistant->group_id = config('polanco.group_id.assistant');
            $group_assistant->contact_id = $person->id;
            $group_assistant->status = 'Added';
            $group_assistant->save();
        }
        // save staff relationship - nb that the individual is contact_a and organization is contact_b
        if ($request->input('is_staff') > 0) {
            $relationship_staff = new \App\Models\Relationship;
            $relationship_staff->contact_id_a = $person->id;
            $relationship_staff->contact_id_b = config('polanco.self.id');
            $relationship_staff->relationship_type_id = config('polanco.relationship_type.staff');
            $relationship_staff->is_active = 1;
            $relationship_staff->save();
            $group_staff = new \App\Models\GroupContact;
            $group_staff->group_id = config('polanco.group_id.staff');
            $group_staff->contact_id = $person->id;
            $group_staff->status = 'Added';
            $group_staff->save();
        }
        // save steward group
        if ($request->input('is_steward') > 0) {
            $group_steward = new \App\Models\GroupContact;
            $group_steward->group_id = config('polanco.group_id.steward');
            $group_steward->contact_id = $person->id;
            $group_steward->status = 'Added';
            $group_steward->save();
        }
        // save board member relationship
        if ($request->input('is_board') > 0) {
            $relationship_board = new \App\Models\Relationship;
            $relationship_board->contact_id_a = config('polanco.self.id');
            $relationship_board->contact_id_b = $person->id;
            $relationship_board->relationship_type_id = config('polanco.relationship_type.board_member');
            $relationship_board->start_date = \Carbon\Carbon::now();
            $relationship_board->is_active = 1;
            $relationship_board->save();
            $group_board = new \App\Models\GroupContact;
            $group_board->group_id = config('polanco.group_id.board');
            $group_board->contact_id = $person->id;
            $group_board->status = 'Added';
            $group_board->save();
        }

        //groups: deacon, priest, bishop, pastor, jesuit, provincial, superior, ambassador, board, innkeeper, director, assistant, staff

        if ($request->input('is_bishop') > 0) {
            $group_bishop = new \App\Models\GroupContact;
            $group_bishop->group_id = config('polanco.group_id.bishop');
            $group_bishop->contact_id = $person->id;
            $group_bishop->status = 'Added';
            $group_bishop->save();
        }
        if ($request->input('is_priest') > 0) {
            $group_priest = new \App\Models\GroupContact;
            $group_priest->group_id = config('polanco.group_id.priest');
            $group_priest->contact_id = $person->id;
            $group_priest->status = 'Added';
            $group_priest->save();
        }
        if ($request->input('is_deacon') > 0) {
            $group_deacon = new \App\Models\GroupContact;
            $group_deacon->group_id = config('polanco.group_id.deacon');
            $group_deacon->contact_id = $person->id;
            $group_deacon->status = 'Added';
            $group_deacon->save();
        }
        if ($request->input('is_pastor') > 0) {
            $group_pastor = new \App\Models\GroupContact;
            $group_pastor->group_id = config('polanco.group_id.pastor');
            $group_pastor->contact_id = $person->id;
            $group_pastor->status = 'Added';
            $group_pastor->save();
        }
        if ($request->input('is_jesuit') > 0) {
            $group_jesuit = new \App\Models\GroupContact;
            $group_jesuit->group_id = config('polanco.group_id.jesuit');
            $group_jesuit->contact_id = $person->id;
            $group_jesuit->status = 'Added';
            $group_jesuit->save();
        }
        if ($request->input('is_superior') > 0) {
            $group_superior = new \App\Models\GroupContact;
            $group_superior->group_id = config('polanco.group_id.superior');
            $group_superior->contact_id = $person->id;
            $group_superior->status = 'Added';
            $group_superior->save();
        }
        if ($request->input('is_provincial') > 0) {
            $group_provincial = new \App\Models\GroupContact;
            $group_provincial->group_id = config('polanco.group_id.provincial');
            $group_provincial->contact_id = $person->id;
            $group_provincial->status = 'Added';
            $group_provincial->save();
        }
        if ($request->input('is_hlm2017') > 0) {
            $group_hlm2017 = new \App\Models\GroupContact;
            $group_hlm2017->group_id = config('polanco.group_id.hlm2017');
            $group_hlm2017->contact_id = $person->id;
            $group_hlm2017->status = 'Added';
            $group_hlm2017->save();
        }

        /*
        $this->save_relationship('parish_id',$parish_id,$person->id,config('polanco.relationship_type.parishioner'));
        $this->save_relationship('is_donor',config('polanco.self.id'),$person->id,config('polanco.relationship_type.donor'));
        $this->save_relationship('is_retreatant',config('polanco.self.id'),$person->id,config('polanco.relationship_type.retreatant'));
        $this->save_relationship('is_volunteer',config('polanco.self.id'),$person->id,config('polanco.relationship_type.volunteer'));
        $this->save_relationship('is_ambassador',config('polanco.self.id'),$person->id,config('polanco.relationship_type.ambassador'));
        $this->save_relationship('is_director',config('polanco.self.id'),$person->id,config('polanco.relationship_type.retreat_director'));
        $this->save_relationship('is_innkeeper',config('polanco.self.id'),$person->id,config('polanco.relationship_type.retreat_innkeeper'));
        $this->save_relationship('is_assistant',config('polanco.self.id'),$person->id,config('polanco.relationship_type.retreat_assistant'));
        $this->save_relationship('is_staff',config('polanco.self.id'),$person->id,config('polanco.relationship_type.staff'));
        $this->save_relationship('is_board',config('polanco.self.id'),$person->id,config('polanco.relationship_type.board_member'));
        */

        // save health, dietary, general and room preference notes

        if (! empty($request->input('note_health'))) {
            $person_note_health = new \App\Models\Note;
            $person_note_health->entity_table = 'contact';
            $person_note_health->entity_id = $person->id;
            $person_note_health->note = $request->input('note_health');
            $person_note_health->subject = 'Health Note';
            $person_note_health->save();
        }

        if (! empty($request->input('note_dietary'))) {
            $person_note_dietary = new \App\Models\Note;
            $person_note_dietary->entity_table = 'contact';
            $person_note_dietary->entity_id = $person->id;
            $person_note_dietary->note = $request->input('note_dietary');
            $person_note_dietary->subject = 'Dietary Note';
            $person_note_dietary->save();
        }

        if (! empty($request->input('note_contact'))) {
            $person_note_contact = new \App\Models\Note;
            $person_note_contact->entity_table = 'contact';
            $person_note_contact->entity_id = $person->id;
            $person_note_contact->note = $request->input('note_contact');
            $person_note_contact->subject = 'Contact Note';
            $person_note_contact->save();
        }

        if (! empty($request->input('note_room_preference'))) {
            $person_note_room_preference = new \App\Models\Note;
            $person_note_room_preference->entity_table = 'contact';
            $person_note_room_preference->entity_id = $person->id;
            $person_note_room_preference->note = $request->input('note_room_preference');
            $person_note_room_preference->subject = 'Room Preference';
            $person_note_room_preference->save();
        }

        if (empty($request->input('languages')) or in_array(0, $request->input('languages'))) {
            $person->languages()->detach();
        } else {
            $person->languages()->sync($request->input('languages'));
        }
        if (empty($request->input('referrals')) or in_array(0, $request->input('referrals'))) {
            $person->referrals()->detach();
        } else {
            $person->referrals()->sync($request->input('referrals'));
        }

        $home_address = new \App\Models\Address;
        $home_address->contact_id = $person->id;
        $home_address->location_type_id = config('polanco.location_type.home');
        $home_address->is_primary = 1;
        $home_address->street_address = $request->input('address_home_address1');
        $home_address->supplemental_address_1 = $request->input('address_home_address2');
        $home_address->city = $request->input('address_home_city');
        $home_address->state_province_id = $request->input('address_home_state');
        $home_address->postal_code = $request->input('address_home_zip');
        $home_address->country_id = $request->input('address_home_country');
        $home_address->save();

        $work_address = new \App\Models\Address;
        $work_address->contact_id = $person->id;
        $work_address->location_type_id = config('polanco.location_type.work');
        $work_address->is_primary = 0;
        $work_address->street_address = $request->input('address_work_address1');
        $work_address->supplemental_address_1 = $request->input('address_work_address2');
        $work_address->city = $request->input('address_work_city');
        $work_address->state_province_id = $request->input('address_work_state');
        $work_address->postal_code = $request->input('address_work_zip');
        $work_address->country_id = $request->input('address_work_country');
        $work_address->save();

        $other_address = new \App\Models\Address;
        $other_address->contact_id = $person->id;
        $other_address->location_type_id = config('polanco.location_type.other');
        $other_address->is_primary = 0;
        $other_address->street_address = $request->input('address_other_address1');
        $other_address->supplemental_address_1 = $request->input('address_other_address2');
        $other_address->city = $request->input('address_other_city');
        $other_address->state_province_id = $request->input('address_other_state');
        $other_address->postal_code = $request->input('address_other_zip');
        $other_address->country_id = $request->input('address_other_country');
        $other_address->save();

        $phone_home_phone = new \App\Models\Phone;
        $phone_home_phone->contact_id = $person->id;
        $phone_home_phone->location_type_id = config('polanco.location_type.home');
        $phone_home_phone->phone = $request->input('phone_home_phone');
        $phone_home_phone->phone_type = 'Phone';
        $phone_home_phone->save();

        $phone_home_mobile = new \App\Models\Phone;
        $phone_home_mobile->contact_id = $person->id;
        $phone_home_mobile->location_type_id = config('polanco.location_type.home');
        $phone_home_mobile->phone = $request->input('phone_home_mobile');
        $phone_home_mobile->phone_type = 'Mobile';
        $phone_home_mobile->save();

        $phone_home_fax = new \App\Models\Phone;
        $phone_home_fax->contact_id = $person->id;
        $phone_home_fax->location_type_id = config('polanco.location_type.home');
        $phone_home_fax->phone = $request->input('phone_home_fax');
        $phone_home_fax->phone_type = 'Fax';
        $phone_home_fax->save();

        $phone_work_phone = new \App\Models\Phone;
        $phone_work_phone->contact_id = $person->id;
        $phone_work_phone->location_type_id = config('polanco.location_type.work');
        $phone_work_phone->phone = $request->input('phone_work_phone');
        $phone_work_phone->phone_type = 'Phone';
        $phone_work_phone->save();

        $phone_work_mobile = new \App\Models\Phone;
        $phone_work_mobile->contact_id = $person->id;
        $phone_work_mobile->location_type_id = config('polanco.location_type.work');
        $phone_work_mobile->phone = $request->input('phone_work_mobile');
        $phone_work_mobile->phone_type = 'Mobile';
        $phone_work_mobile->save();

        $phone_work_fax = new \App\Models\Phone;
        $phone_work_fax->contact_id = $person->id;
        $phone_work_fax->location_type_id = config('polanco.location_type.work');
        $phone_work_fax->phone = $request->input('phone_work_fax');
        $phone_work_fax->phone_type = 'Fax';
        $phone_work_fax->save();

        $phone_other_phone = new \App\Models\Phone;
        $phone_other_phone->contact_id = $person->id;
        $phone_other_phone->location_type_id = config('polanco.location_type.other');
        $phone_other_phone->phone = $request->input('phone_other_phone');
        $phone_other_phone->phone_type = 'Phone';
        $phone_other_phone->save();

        $phone_other_mobile = new \App\Models\Phone;
        $phone_other_mobile->contact_id = $person->id;
        $phone_other_mobile->location_type_id = config('polanco.location_type.other');
        $phone_other_mobile->phone = $request->input('phone_other_mobile');
        $phone_other_mobile->phone_type = 'Mobile';
        $phone_other_mobile->save();

        $phone_other_fax = new \App\Models\Phone;
        $phone_other_fax->contact_id = $person->id;
        $phone_other_fax->location_type_id = config('polanco.location_type.other');
        $phone_other_fax->phone = $request->input('phone_other_fax');
        $phone_other_fax->phone_type = 'Fax';
        $phone_other_fax->save();

        $email_home = new \App\Models\Email;
        $email_home->contact_id = $person->id;
        $email_home->location_type_id = config('polanco.location_type.home');
        $email_home->email = $request->input('email_home');
        $email_home->is_primary = 1;
        $email_home->save();

        $email_work = new \App\Models\Email;
        $email_work->contact_id = $person->id;
        $email_work->location_type_id = config('polanco.location_type.work');
        $email_work->email = $request->input('email_work');
        $email_work->save();

        $email_other = new \App\Models\Email;
        $email_other->contact_id = $person->id;
        $email_other->location_type_id = config('polanco.location_type.other');
        $email_other->email = $request->input('email_other');
        $email_other->save();

        $url_main = new \App\Models\Website;
        $url_main->contact_id = $person->id;
        $url_main->url = $request->input('url_main');
        $url_main->website_type = 'Main';
        $url_main->save();

        $url_work = new \App\Models\Website;
        $url_work->contact_id = $person->id;
        $url_work->url = $request->input('url_work');
        $url_work->website_type = 'Work';
        $url_work->save();

        $url_facebook = new \App\Models\Website;
        $url_facebook->contact_id = $person->id;
        $url_facebook->url = $request->input('url_facebook');
        $url_facebook->website_type = 'Facebook';
        $url_facebook->save();

        $url_google = new \App\Models\Website;
        $url_google->contact_id = $person->id;
        $url_google->url = $request->input('url_google');
        $url_google->website_type = 'Google';
        $url_google->save();

        $url_instagram = new \App\Models\Website;
        $url_instagram->contact_id = $person->id;
        $url_instagram->url = $request->input('url_instagram');
        $url_instagram->website_type = 'Instagram';
        $url_instagram->save();

        $url_linkedin = new \App\Models\Website;
        $url_linkedin->contact_id = $person->id;
        $url_linkedin->url = $request->input('url_linkedin');
        $url_linkedin->website_type = 'LinkedIn';
        $url_linkedin->save();

        $url_twitter = new \App\Models\Website;
        $url_twitter->contact_id = $person->id;
        $url_twitter->url = $request->input('url_twitter');
        $url_twitter->website_type = 'Twitter';
        $url_twitter->save();

        flash('Person: <a href="'.url('/person/'.$person->id).'">'.$person->display_name.'</a> added')->success();

        return Redirect::action('PersonController@show', $person->id); //

        //return Redirect::action('PersonController@index');//
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
        $person = \App\Models\Contact::with('addresses.country', 'addresses.location', 'addresses.state', 'emails.location', 'emergency_contact', 'ethnicity', 'languages', 'notes', 'occupation', 'parish.contact_a.address_primary', 'parish.contact_a.diocese.contact_a', 'phones.location', 'prefix', 'suffix', 'religion', 'touchpoints.staff', 'websites',
        'groups.group', 'a_relationships.relationship_type', 'a_relationships.contact_b', 'b_relationships.relationship_type', 'b_relationships.contact_a', 'event_registrations', 'donations.payments')->findOrFail($id);
        //dd($person->donations);
        $files = \App\Models\Attachment::whereEntity('contact')->whereEntityId($person->id)->whereFileTypeId(config('polanco.file_type.contact_attachment'))->get();
        $relationship_types = [];
        $relationship_types['Child'] = 'Child';
        $relationship_types['Employee'] = 'Employee';
        $relationship_types['Husband'] = 'Husband';
        $relationship_types['Parent'] = 'Parent';
        $relationship_types['Parishioner'] = 'Parishioner';
        $relationship_types['Sibling'] = 'Sibling';
        $relationship_types['Wife'] = 'Wife';

        //dd($files);
        //not at all elegant but this parses out the notes for easy display and use in the edit blade
        $person->note_health = '';
        $person->note_dietary = '';
        $person->note_contact = '';
        $person->note_room_preference = '';
        if (! empty($person->notes)) {
            foreach ($person->notes as $note) {
                if ($note->subject == 'Health Note') {
                    $person->note_health = $note->note;
                }

                if ($note->subject == 'Dietary Note') {
                    $person->note_dietary = $note->note;
                }

                if ($note->subject == 'Contact Note') {
                    $person->note_contact = $note->note;
                }

                if ($note->subject == 'Room Preference') {
                    $person->note_room_preference = $note->note;
                }
            }
        }
        /*
        //not pretty but moves some of the processing to the controller rather than the blade
        $person->parish_id = '';
        $person->parish_name = '';
        if (! empty($person->parish)) {
            $person->parish_id = $person->parish->contact_id_a;
            $person->parish_name = $person->parish->contact_a->organization_name.' ('.$person->parish->contact_a->address_primary_city.') - '.$person->parish->contact_a->diocese->contact_a->organization_name;
        }
        */
        $touchpoints = \App\Models\Touchpoint::wherePersonId($person->id)->orderBy('touched_at', 'desc')->with('staff')->get();
        $registrations = \App\Models\Registration::whereContactId($person->id)->get();
        $registrations = $registrations->sortByDesc(function ($registration) {
            return $registration->retreat_start_date;
        });
        //dd($registrations);
        return view('persons.show', compact('person', 'files', 'relationship_types', 'touchpoints', 'registrations')); //
    }

    /**
     * Display the name and mailing address for a contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * TODO: Shift suggestion - review these instances for dynamic validation rules - handle in a custom request like EnvelopeRequest
     */
    public function envelope($id, Request $request)
    {
        $this->authorize('show-contact');

        //default size = 10; logo = false
        $size = (string) '10';
        $logo = (bool) 0;
        $name = (string) 'household';

        $person = \App\Models\Contact::findOrFail($id);
        $v = Validator::make($request->all(), [
             'size' => Rule::in(['10', '9x6']),
             'logo' => 'boolean',
             'name' => Rule::in(['full', 'display', 'household']),
         ]);
        if (empty($v->invalid())) {
            $size = isset($request->size) ? (string) $request->size : $size;
            $logo = isset($request->logo) ? (bool) $request->logo : $logo;
            $name = isset($request->name) ? (string) $request->name : $name;
            $person->logo = $logo;
            switch ($name) {
             case 'full':
                $person->addressee = $person->full_name;
                break;
             case 'display':
                $person->addressee = $person->display_name;
                break;
             default:
                $person->addressee = $person->agc_household_name;
                break;
           }
        } else {
            return Redirect::action('PersonController@show', $person->id);
        }

        switch ($size) {
           case '10':
               return view('persons.envelope10', compact('person'));
               break;
           case '9x6':
               return view('persons.envelope9x6', compact('person'));
               break;
           default:
               return Redirect::action('PersonController@show', $person->id);
        }
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
        $person = \App\Models\Contact::with('prefix', 'suffix', 'addresses.location', 'emails.location', 'phones.location', 'websites', 'parish', 'emergency_contact', 'notes')->findOrFail($id);
        //dd($person);

        $parishes = \App\Models\Contact::whereSubcontactType(config('polanco.contact_type.parish'))->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        $parish_list[0] = 'N/A';
        $contact_types = \App\Models\ContactType::whereIsReserved(true)->pluck('label', 'id');
        $subcontact_types = \App\Models\ContactType::whereIsReserved(false)->whereIsActive(true)->pluck('label', 'id');
        $subcontact_types->prepend('N/A', 0);
        // while probably not the most efficient way of doing this it gets me the result
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }
        if (! empty($person->parish)) {
            $person->parish_id = $person->parish->contact_id_a;
        } else {
            $person->parish_id = 0;
        }

        //again not at all elegant but this parses out the notes for easy display and use in the edit blade
        $person->note_health = '';
        $person->note_dietary = '';
        $person->note_contact = '';
        $person->note_room_preference = '';

        if (! empty($person->notes)) {
            foreach ($person->notes as $note) {
                if ($note->subject == 'Health Note') {
                    $person->note_health = $note->note;
                }

                if ($note->subject == 'Dietary Note') {
                    $person->note_dietary = $note->note;
                }

                if ($note->subject == 'Contact Note') {
                    $person->note_contact = $note->note;
                }

                if ($note->subject == 'Room Preference') {
                    $person->note_room_preference = $note->note;
                }
            }
        }
        //dd($person);
        $countries = \App\Models\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', 0);
        $ethnicities = \App\Models\Ethnicity::orderBy('ethnicity')->pluck('ethnicity', 'id');
        $ethnicities->prepend('N/A', 0);
        $genders = \App\Models\Gender::orderBy('name')->pluck('name', 'id');
        $genders->prepend('N/A', 0);
        $languages = \App\Models\Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('N/A', 0);
        $referrals = \App\Models\Referral::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $referrals->prepend('N/A', 0);
        $prefixes = \App\Models\Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('N/A', 0);
        $religions = \App\Models\Religion::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $religions->prepend('N/A', 0);
        $states = \App\Models\StateProvince::orderBy('name')->whereCountryId(config('polanco.country_id_usa'))->pluck('name', 'id');
        $states->prepend('N/A', 0);
        $suffixes = \App\Models\Suffix::orderBy('name')->pluck('name', 'id');
        $suffixes->prepend('N/A', 0);
        $occupations = \App\Models\Ppd_occupation::orderBy('name')->pluck('name', 'id');
        $occupations->prepend('N/A', 0);
        $preferred_communication_methods = config('polanco.preferred_communication_method');

        //create defaults array for easier pre-populating of default values on edit/update blade
        // initialize defaults to avoid undefined index errors
        $defaults = [];
        $defaults['Home']['street_address'] = '';
        $defaults['Home']['supplemental_address_1'] = '';
        $defaults['Home']['city'] = '';
        $defaults['Home']['state_province_id'] = '';
        $defaults['Home']['postal_code'] = '';
        $defaults['Home']['country_id'] = '';
        $defaults['Home']['Phone'] = '';
        $defaults['Home']['Mobile'] = '';
        $defaults['Home']['Fax'] = '';
        $defaults['Home']['email'] = '';

        $defaults['Work']['street_address'] = '';
        $defaults['Work']['supplemental_address_1'] = '';
        $defaults['Work']['city'] = '';
        $defaults['Work']['state_province_id'] = '';
        $defaults['Work']['postal_code'] = '';
        $defaults['Work']['country_id'] = '';
        $defaults['Work']['Phone'] = '';
        $defaults['Work']['Mobile'] = '';
        $defaults['Work']['Fax'] = '';
        $defaults['Work']['email'] = '';

        $defaults['Other']['street_address'] = '';
        $defaults['Other']['supplemental_address_1'] = '';
        $defaults['Other']['city'] = '';
        $defaults['Other']['state_province_id'] = '';
        $defaults['Other']['postal_code'] = '';
        $defaults['Other']['country_id'] = '';
        $defaults['Other']['Phone'] = '';
        $defaults['Other']['Mobile'] = '';
        $defaults['Other']['Fax'] = '';
        $defaults['Other']['email'] = '';

        $defaults['Main']['url'] = '';
        $defaults['Work']['url'] = '';
        $defaults['Facebook']['url'] = '';
        $defaults['Google']['url'] = '';
        $defaults['Instagram']['url'] = '';
        $defaults['LinkedIn']['url'] = '';
        $defaults['Twitter']['url'] = '';

        foreach ($person->addresses as $address) {
            $defaults[$address->location->name]['street_address'] = $address->street_address;
            $defaults[$address->location->name]['supplemental_address_1'] = $address->supplemental_address_1;
            $defaults[$address->location->name]['city'] = $address->city;
            $defaults[$address->location->name]['state_province_id'] = $address->state_province_id;
            $defaults[$address->location->name]['postal_code'] = $address->postal_code;
            $defaults[$address->location->name]['country_id'] = $address->country_id;
        }

        foreach ($person->phones as $phone) {
            $defaults[$phone->location->name][$phone->phone_type] = $phone->phone.$phone->phone_extension;
        }

        foreach ($person->emails as $email) {
            $defaults[$email->location->name]['email'] = $email->email;
        }

        foreach ($person->websites as $website) {
            $defaults[$website->website_type]['url'] = $website->url;
        }
        //dd($person);

        return view('persons.edit', compact('prefixes', 'suffixes', 'person', 'parish_list', 'ethnicities', 'states', 'countries', 'genders', 'languages', 'defaults', 'religions', 'occupations', 'contact_types', 'subcontact_types', 'referrals', 'preferred_communication_methods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonRequest $request, $id)
    {
        $this->authorize('update-contact');

        $person = \App\Models\Contact::with('addresses.location', 'emails.location', 'phones.location', 'websites', 'emergency_contact', 'parish')->findOrFail($id);

        $person->contact_type = $request->input('contact_type');
        $person->subcontact_type = $request->input('subcontact_type');

        $person->prefix_id = $request->input('prefix_id');
        $person->first_name = $request->input('first_name');
        $person->middle_name = $request->input('middle_name');
        $person->last_name = $request->input('last_name');
        $person->suffix_id = $request->input('suffix_id');
        $person->nick_name = $request->input('nick_name');

        if (! empty($request->input('display_name'))) {
            $person->display_name = $request->input('display_name');
        } // if no display_name is sent in the request, leave the existing data
        if (! empty($request->input('sort_name'))) {
            $person->sort_name = $request->input('sort_name');
        } // if no sort_name is sent in the request, leave the existing data

        //demographic info
        $person->gender_id = $request->input('gender_id');
        $person->birth_date = $request->input('birth_date');
        $person->ethnicity_id = $request->input('ethnicity_id');
        $person->religion_id = $request->input('religion_id');
        $person->occupation_id = $request->input('occupation_id');

        // communication preferences
        $person->preferred_communication_method = $request->input('preferred_communication_method_id') ?: 0;
        $person->do_not_mail = $request->input('do_not_mail') ?: 0;
        $person->do_not_email = $request->input('do_not_email') ?: 0;
        $person->do_not_phone = $request->input('do_not_phone') ?: 0;
        $person->do_not_sms = $request->input('do_not_sms') ?: 0;

        if (empty($request->input('languages')) or in_array(0, $request->input('languages'))) {
            $person->languages()->detach();
        } else {
            $person->languages()->sync($request->input('languages'));
        }
        if (empty($request->input('referrals')) or in_array(0, $request->input('referrals'))) {
            $person->referrals()->detach();
        } else {
            $person->referrals()->sync($request->input('referrals'));
        }

        // CiviCRM stores the language name rather than the language id in the contact's preferred_language field
        if (! empty($request->input('preferred_language_id'))) {
            $language = \App\Models\Language::findOrFail($request->input('preferred_language_id'));
            $person->preferred_language = $language->name;
        }
        if (empty($request->input('is_deceased'))) {
            $person->is_deceased = 0;
        } else {
            $person->is_deceased = $request->input('is_deceased');
        }
        if (empty($request->input('deceased_date'))) {
            $person->deceased_date = null;
        } else {
            $person->deceased_date = $request->input('deceased_date');
            $person->is_deceased = 1;
        }
        if ($person->is_deceased == true) { // we only want to communicate with the dead through prayer
            $person->do_not_mail = true;
            $person->do_not_email = true;
            $person->do_not_phone = true;
            $person->do_not_sms = true;
        }

        $person->save();
        if (null !== $request->file('avatar')) {
            $description = 'Avatar for '.$person->full_name;
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('avatar'), 'contact', $person->id, 'avatar', $description);
        }

        if (null !== $request->file('attachment')) {
            $description = $request->input('attachment_description');
            $attachment = new AttachmentController;
            $attachment->update_attachment($request->file('attachment'), 'contact', $person->id, 'attachment', $description);
        }

        //emergency contact info
        $emergency_contact = \App\Models\EmergencyContact::firstOrNew(['contact_id'=>$person->id]);
        $emergency_contact->contact_id = $person->id;
        $emergency_contact->name = $request->input('emergency_contact_name');
        $emergency_contact->relationship = $request->input('emergency_contact_relationship');
        $emergency_contact->phone = $request->input('emergency_contact_phone');
        $emergency_contact->phone_alternate = $request->input('emergency_contact_phone_alternate');
        $emergency_contact->save();

        //dd($person);
        // save parishioner relationship
        // TEST: does unset work?
        if ($request->input('parish_id') > 0) {
            $relationship_parishioner = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.parishioner'), 'is_active'=>1]);
            $relationship_parishioner->contact_id_a = $request->input('parish_id');
            $relationship_parishioner->contact_id_b = $person->id;
            $relationship_parishioner->relationship_type_id = config('polanco.relationship_type.parishioner');
            $relationship_parishioner->is_active = 1;
            $relationship_parishioner->save();
        }
        if ($request->input('parish_id') == 0) {
            $relationship_parishioner = \App\Models\Relationship::whereContactIdB($person->id)->whereRelationshipTypeId(config('polanco.relationship_type.parishioner'))->whereIsActive(1)->first();
            if (isset($relationship_parishioner)) {
                $relationship_parishioner->delete();
            }
        }

        // save health, dietary, general and room preference notes

        if (null !== ($request->input('note_health'))) {
            $person_note_health = \App\Models\Note::firstOrNew(['entity_table'=>'contact', 'entity_id'=>$person->id, 'subject'=>'Health Note']);
            $person_note_health->entity_table = 'contact';
            $person_note_health->entity_id = $person->id;
            $person_note_health->note = $request->input('note_health');
            $person_note_health->subject = 'Health Note';
            $person_note_health->save();
        } else {
            $person_note_health = \App\Models\Note::whereEntityTable('contact')->whereEntityId($person->id)->whereSubject('Health Note')->first();
            if (isset($person_note_health) && $person_note_health->id > 0) {
                $person_note_health->delete();
            }
        }

        if (null !== ($request->input('note_dietary'))) {
            $person_note_dietary = \App\Models\Note::firstOrNew(['entity_table'=>'contact', 'entity_id'=>$person->id, 'subject'=>'Dietary Note']);
            $person_note_dietary->entity_table = 'contact';
            $person_note_dietary->entity_id = $person->id;
            $person_note_dietary->note = $request->input('note_dietary');
            $person_note_dietary->subject = 'Dietary Note';
            $person_note_dietary->save();
        } else {
            $person_note_dietary = \App\Models\Note::whereEntityTable('contact')->whereEntityId($person->id)->whereSubject('Dietary Note')->first();
            if (isset($person_note_dietary) && $person_note_dietary->id > 0) {
                $person_note_dietary->delete();
            }
        }

        if (null !== ($request->input('note_contact'))) {
            $person_note_contact = \App\Models\Note::firstOrNew(['entity_table'=>'contact', 'entity_id'=>$person->id, 'subject'=>'Contact Note']);
            $person_note_contact->entity_table = 'contact';
            $person_note_contact->entity_id = $person->id;
            $person_note_contact->note = $request->input('note_contact');
            $person_note_contact->subject = 'Contact Note';
            $person_note_contact->save();
        } else {
            $person_note_contact = \App\Models\Note::whereEntityTable('contact')->whereEntityId($person->id)->whereSubject('Contact Note')->first();
            if (isset($person_note_contact) && $person_note_contact->id > 0) {
                $person_note_contact->delete();
            }
        }

        if (null !== ($request->input('note_room_preference'))) {
            $person_note_room_preference = \App\Models\Note::firstOrNew(['entity_table'=>'contact', 'entity_id'=>$person->id, 'subject'=>'Room Preference']);
            $person_note_room_preference->entity_table = 'contact';
            $person_note_room_preference->entity_id = $person->id;
            $person_note_room_preference->note = $request->input('note_room_preference');
            $person_note_room_preference->subject = 'Room Preference';
            $person_note_room_preference->save();
        } else {
            $person_note_room_preference = \App\Models\Note::whereEntityTable('contact')->whereEntityId($person->id)->whereSubject('Room Preference')->first();
            if (isset($person_note_room_preference) && $person_note_room_preference->id > 0) {
                $person_note_room_preference->delete();
            }
        }

        $home_address = \App\Models\Address::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.home')]);
        $home_address->contact_id = $person->id;
        $home_address->location_type_id = config('polanco.location_type.home');
        $home_address->is_primary = 1;
        $home_address->street_address = $request->input('address_home_address1');
        $home_address->supplemental_address_1 = $request->input('address_home_address2');
        $home_address->city = $request->input('address_home_city');
        $home_address->state_province_id = $request->input('address_home_state');
        $home_address->postal_code = $request->input('address_home_zip');
        $home_address->country_id = $request->input('address_home_country');
        $home_address->save();

        $work_address = \App\Models\Address::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.work')]);
        $work_address->contact_id = $person->id;
        $work_address->location_type_id = config('polanco.location_type.work');
        $work_address->is_primary = 0;
        $work_address->street_address = $request->input('address_work_address1');
        $work_address->supplemental_address_1 = $request->input('address_work_address2');
        $work_address->city = $request->input('address_work_city');
        $work_address->state_province_id = $request->input('address_work_state');
        $work_address->postal_code = $request->input('address_work_zip');
        $work_address->country_id = $request->input('address_work_country');
        $work_address->save();

        $other_address = \App\Models\Address::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.other')]);
        $other_address->contact_id = $person->id;
        $other_address->location_type_id = config('polanco.location_type.other');
        $other_address->is_primary = 0;
        $other_address->street_address = $request->input('address_other_address1');
        $other_address->supplemental_address_1 = $request->input('address_other_address2');
        $other_address->city = $request->input('address_other_city');
        $other_address->state_province_id = $request->input('address_other_state');
        $other_address->postal_code = $request->input('address_other_zip');
        $other_address->country_id = $request->input('address_other_country');
        $other_address->save();
        // because of how the phone_ext field is handled by the model, reset to null on every update to ensure it gets removed and then re-added during the update
        $phone_home_phone = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.home'), 'phone_type'=>'Phone']);
        $phone_home_phone->phone_ext = null;
        $phone_home_phone->contact_id = $person->id;
        $phone_home_phone->location_type_id = config('polanco.location_type.home');
        $phone_home_phone->phone = $request->input('phone_home_phone');
        $phone_home_phone->phone_type = 'Phone';
        $phone_home_phone->save();

        $phone_home_mobile = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.home'), 'phone_type'=>'Mobile']);
        $phone_home_mobile->phone_ext = null;
        $phone_home_mobile->contact_id = $person->id;
        $phone_home_mobile->location_type_id = config('polanco.location_type.home');
        $phone_home_mobile->phone = $request->input('phone_home_mobile');
        $phone_home_mobile->phone_type = 'Mobile';
        $phone_home_mobile->save();

        $phone_home_fax = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.home'), 'phone_type'=>'Fax']);
        $phone_home_fax->phone_ext = null;
        $phone_home_fax->contact_id = $person->id;
        $phone_home_fax->location_type_id = config('polanco.location_type.home');
        $phone_home_fax->phone = $request->input('phone_home_fax');
        $phone_home_fax->phone_type = 'Fax';
        $phone_home_fax->save();

        $phone_work_phone = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.work'), 'phone_type'=>'Phone']);
        $phone_work_phone->phone_ext = null;
        $phone_work_phone->contact_id = $person->id;
        $phone_work_phone->location_type_id = config('polanco.location_type.work');
        $phone_work_phone->phone = $request->input('phone_work_phone');
        $phone_work_phone->phone_type = 'Phone';
        $phone_work_phone->save();

        $phone_work_mobile = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.work'), 'phone_type'=>'Mobile']);
        $phone_work_mobile->phone_ext = null;
        $phone_work_mobile->contact_id = $person->id;
        $phone_work_mobile->location_type_id = config('polanco.location_type.work');
        $phone_work_mobile->phone = $request->input('phone_work_mobile');
        $phone_work_mobile->phone_type = 'Mobile';
        $phone_work_mobile->save();

        $phone_work_fax = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.work'), 'phone_type'=>'Fax']);
        $phone_work_fax->phone_ext = null;
        $phone_work_fax->contact_id = $person->id;
        $phone_work_fax->location_type_id = config('polanco.location_type.work');
        $phone_work_fax->phone = $request->input('phone_work_fax');
        $phone_work_fax->phone_type = 'Fax';
        $phone_work_fax->save();

        $phone_other_phone = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.other'), 'phone_type'=>'Phone']);
        $phone_other_phone->phone_ext = null;
        $phone_other_phone->contact_id = $person->id;
        $phone_other_phone->location_type_id = config('polanco.location_type.other');
        $phone_other_phone->phone = $request->input('phone_other_phone');
        $phone_other_phone->phone_type = 'Phone';
        $phone_other_phone->save();

        $phone_other_mobile = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.other'), 'phone_type'=>'Mobile']);
        $phone_other_mobile->phone_ext = null;
        $phone_other_mobile->contact_id = $person->id;
        $phone_other_mobile->location_type_id = config('polanco.location_type.other');
        $phone_other_mobile->phone = $request->input('phone_other_mobile');
        $phone_other_mobile->phone_type = 'Mobile';
        $phone_other_mobile->save();

        $phone_other_fax = \App\Models\Phone::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.other'), 'phone_type'=>'Fax']);
        $phone_other_fax->phone_ext = null;
        $phone_other_fax->contact_id = $person->id;
        $phone_other_fax->location_type_id = config('polanco.location_type.other');
        $phone_other_fax->phone = $request->input('phone_other_fax');
        $phone_other_fax->phone_type = 'Fax';
        $phone_other_fax->save();

        $email_home = \App\Models\Email::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.home')]);
        $email_home->contact_id = $person->id;
        $email_home->location_type_id = config('polanco.location_type.home');
        $email_home->email = $request->input('email_home');
        $email_home->save();

        $email_work = \App\Models\Email::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.work')]);
        $email_work->contact_id = $person->id;
        $email_work->location_type_id = config('polanco.location_type.work');
        $email_work->email = $request->input('email_work');
        $email_work->save();

        $email_other = \App\Models\Email::firstOrNew(['contact_id'=>$person->id, 'location_type_id'=>config('polanco.location_type.other')]);
        $email_other->contact_id = $person->id;
        $email_other->location_type_id = config('polanco.location_type.other');
        $email_other->email = $request->input('email_other');
        $email_other->save();

        $url_main = \App\Models\Website::firstOrNew(['contact_id'=>$person->id, 'website_type'=>'Main']);
        $url_main->contact_id = $person->id;
        $url_main->url = $request->input('url_main');
        $url_main->website_type = 'Main';
        $url_main->save();

        $url_work = \App\Models\Website::firstOrNew(['contact_id'=>$person->id, 'website_type'=>'Work']);
        $url_work->contact_id = $person->id;
        $url_work->url = $request->input('url_work');
        $url_work->website_type = 'Work';
        $url_work->save();

        $url_facebook = \App\Models\Website::firstOrNew(['contact_id'=>$person->id, 'website_type'=>'Facebook']);
        $url_facebook->contact_id = $person->id;
        $url_facebook->url = $request->input('url_facebook');
        $url_facebook->website_type = 'Facebook';
        $url_facebook->save();

        $url_google = \App\Models\Website::firstOrNew(['contact_id'=>$person->id, 'website_type'=>'Google']);
        $url_google->contact_id = $person->id;
        $url_google->url = $request->input('url_google');
        $url_google->website_type = 'Google';
        $url_google->save();

        $url_instagram = \App\Models\Website::firstOrNew(['contact_id'=>$person->id, 'website_type'=>'Instagram']);
        $url_instagram->contact_id = $person->id;
        $url_instagram->url = $request->input('url_instagram');
        $url_instagram->website_type = 'Instagram';
        $url_instagram->save();

        $url_linkedin = \App\Models\Website::firstOrNew(['contact_id'=>$person->id, 'website_type'=>'LinkedIn']);
        $url_linkedin->contact_id = $person->id;
        $url_linkedin->url = $request->input('url_linkedin');
        $url_linkedin->website_type = 'LinkedIn';
        $url_linkedin->save();

        $url_twitter = \App\Models\Website::firstOrNew(['contact_id'=>$person->id, 'website_type'=>'Twitter']);
        $url_twitter->contact_id = $person->id;
        $url_twitter->url = $request->input('url_twitter');
        $url_twitter->website_type = 'Twitter';
        $url_twitter->save();

        // relationships: donor, retreatant, volunteer, ambassador, director, innkeeper, assistant, staff, board
        $relationship_donor = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.donor'), 'is_active'=>1]);
        if ($request->input('is_donor') == 0) {
            $relationship_donor->delete();
        } else {
            $relationship_donor->contact_id_a = config('polanco.self.id');
            $relationship_donor->contact_id_b = $person->id;
            $relationship_donor->relationship_type_id = config('polanco.relationship_type.donor');
            $relationship_donor->is_active = 1;
            $relationship_donor->save();
        }
        $relationship_retreatant = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.retreatant'), 'is_active'=>1]);

        if ($request->input('is_retreatant') == 0) {
            $relationship_retreatant->delete();
        } else {
            $relationship_retreatant->contact_id_a = config('polanco.self.id');
            $relationship_retreatant->contact_id_b = $person->id;
            $relationship_retreatant->relationship_type_id = config('polanco.relationship_type.retreatant');
            $relationship_retreatant->is_active = 1;
            $relationship_retreatant->save();
        }

        $relationship_volunteer = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.volunteer'), 'is_active'=>1]);
        if ($request->input('is_volunteer') == 0) {
            $relationship_volunteer->delete();
        } else {
            $relationship_volunteer->contact_id_a = config('polanco.self.id');
            $relationship_volunteer->contact_id_b = $person->id;
            $relationship_volunteer->relationship_type_id = config('polanco.relationship_type.volunteer');
            $relationship_volunteer->is_active = 1;
            $relationship_volunteer->save();
        }

        $relationship_ambassador = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.ambassador'), 'is_active'=>1]);
        if ($request->input('is_ambassador') == 0) {
            $relationship_ambassador->delete();
        } else {
            $relationship_ambassador->contact_id_a = config('polanco.self.id');
            $relationship_ambassador->contact_id_b = $person->id;
            $relationship_ambassador->relationship_type_id = config('polanco.relationship_type.ambassador');
            $relationship_ambassador->is_active = 1;
            $relationship_ambassador->save();
        }

        $relationship_director = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.retreat_director'), 'is_active'=>1]);
        if ($request->input('is_director') == 0) {
            $relationship_director->delete();
        } else {
            $relationship_director->contact_id_a = config('polanco.self.id');
            $relationship_director->contact_id_b = $person->id;
            $relationship_director->relationship_type_id = config('polanco.relationship_type.retreat_director');
            $relationship_director->is_active = 1;
            $relationship_director->save();
        }

        $relationship_innkeeper = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.retreat_innkeeper'), 'is_active'=>1]);
        if ($request->input('is_innkeeper') == 0) {
            $relationship_innkeeper->delete();
        } else {
            $relationship_innkeeper->contact_id_a = config('polanco.self.id');
            $relationship_innkeeper->contact_id_b = $person->id;
            $relationship_innkeeper->relationship_type_id = config('polanco.relationship_type.retreat_innkeeper');
            $relationship_innkeeper->is_active = 1;
            $relationship_innkeeper->save();
        }

        $relationship_assistant = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.retreat_assistant'), 'is_active'=>1]);
        if ($request->input('is_assistant') == 0) {
            $relationship_assistant->delete();
        } else {
            $relationship_assistant->contact_id_a = config('polanco.self.id');
            $relationship_assistant->contact_id_b = $person->id;
            $relationship_assistant->relationship_type_id = config('polanco.relationship_type.retreat_assistant');
            $relationship_assistant->is_active = 1;
            $relationship_assistant->save();
        }

        $relationship_staff = \App\Models\Relationship::firstOrNew(['contact_id_a'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.staff'), 'is_active'=>1]);
        if ($request->input('is_staff') == 0) {
            $relationship_staff->delete();
        } else {
            $relationship_staff->contact_id_a = $person->id;
            $relationship_staff->contact_id_b = config('polanco.self.id');
            $relationship_staff->relationship_type_id = config('polanco.relationship_type.staff');
            $relationship_staff->is_active = 1;
            $relationship_staff->save();
        }

        // for Board Members we are not deleting the relationship but ending it and making it inactive
        $relationship_board = \App\Models\Relationship::firstOrNew(['contact_id_b'=>$person->id, 'relationship_type_id'=>config('polanco.relationship_type.board_member')]);
        if ($request->input('is_board') == 0) {
            if (isset($relationship_board->id)) {
                $relationship_board->end_date = \Carbon\Carbon::now();
                $relationship_board->is_active = 0;
                $relationship_board->save();
            }
        } else {
            $relationship_board->contact_id_a = config('polanco.self.id');
            $relationship_board->contact_id_b = $person->id;
            $relationship_board->relationship_type_id = config('polanco.relationship_type.board_member');
            $relationship_board->start_date = \Carbon\Carbon::now();
            $relationship_board->is_active = 1;
            $relationship_board->save();
        }

        //groups:
        $group_ambassador = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.ambassador'), 'status'=>'Added']);
        if ($request->input('is_ambassador') == 0) {
            $group_ambassador->delete();
        } else {
            $group_ambassador->contact_id = $person->id;
            $group_ambassador->group_id = config('polanco.group_id.ambassador');
            $group_ambassador->status = 'Added';
            $group_ambassador->deleted_at = null;
            $group_ambassador->save();
        }

        $group_hlm2017 = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.hlm2017'), 'status'=>'Added']);
        if ($request->input('is_hlm2017') == 0) {
            $group_hlm2017->delete();
        } else {
            $group_hlm2017->contact_id = $person->id;
            $group_hlm2017->group_id = config('polanco.group_id.hlm2017');
            $group_hlm2017->status = 'Added';
            $group_hlm2017->deleted_at = null;
            $group_hlm2017->save();
        }

        $group_volunteer = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.volunteer'), 'status'=>'Added']);
        if ($request->input('is_volunteer') == 0) {
            $group_volunteer->delete();
        } else {
            $group_volunteer->contact_id = $person->id;
            $group_volunteer->group_id = config('polanco.group_id.volunteer');
            $group_volunteer->status = 'Added';
            $group_volunteer->deleted_at = null;
            $group_volunteer->save();
        }

        $group_bishop = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.bishop'), 'status'=>'Added']);
        if ($request->input('is_bishop') == 0) {
            $group_bishop->delete();
        } else {
            $group_bishop->contact_id = $person->id;
            $group_bishop->group_id = config('polanco.group_id.bishop');
            $group_bishop->status = 'Added';
            $group_bishop->deleted_at = null;
            $group_bishop->save();
        }

        $group_priest = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.priest'), 'status'=>'Added']);
        if ($request->input('is_priest') == 0) {
            $group_priest->delete();
        } else {
            $group_priest->contact_id = $person->id;
            $group_priest->group_id = config('polanco.group_id.priest');
            $group_priest->status = 'Added';
            $group_priest->deleted_at = null;
            $group_priest->save();
        }

        $group_deacon = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.deacon'), 'status'=>'Added']);
        if ($request->input('is_deacon') == 0) {
            $group_deacon->delete();
        } else {
            $group_deacon->contact_id = $person->id;
            $group_deacon->group_id = config('polanco.group_id.deacon');
            $group_deacon->status = 'Added';
            $group_deacon->deleted_at = null;
            $group_deacon->save();
        }

        $group_pastor = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.pastor'), 'status'=>'Added']);
        if ($request->input('is_pastor') == 0) {
            $group_pastor->delete();
        } else {
            $group_pastor->contact_id = $person->id;
            $group_pastor->group_id = config('polanco.group_id.pastor');
            $group_pastor->status = 'Added';
            $group_pastor->deleted_at = null;
            $group_pastor->save();
        }

        $group_jesuit = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.jesuit'), 'status'=>'Added']);
        if ($request->input('is_jesuit') == 0) {
            $group_jesuit->delete();
        } else {
            $group_jesuit->contact_id = $person->id;
            $group_jesuit->group_id = config('polanco.group_id.jesuit');
            $group_jesuit->status = 'Added';
            $group_jesuit->deleted_at = null;
            $group_jesuit->save();
        }

        $group_provincial = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.provincial'), 'status'=>'Added']);
        if ($request->input('is_provincial') == 0) {
            $group_provincial->delete();
        } else {
            $group_provincial->contact_id = $person->id;
            $group_provincial->group_id = config('polanco.group_id.provincial');
            $group_provincial->status = 'Added';
            $group_provincial->deleted_at = null;
            $group_provincial->save();
        }

        $group_superior = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.superior'), 'status'=>'Added']);
        if ($request->input('is_superior') == 0) {
            $group_superior->delete();
        } else {
            $group_superior->contact_id = $person->id;
            $group_superior->group_id = config('polanco.group_id.superior');
            $group_superior->status = 'Added';
            $group_superior->deleted_at = null;
            $group_superior->save();
        }

        $group_board = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.board')]);
        if ($request->input('is_board') == 0) {
            if (isset($group_board->id)) {
                $group_board->status = 'Removed';
                $group_board->save();
            }
        } else {
            $group_board->contact_id = $person->id;
            $group_board->group_id = config('polanco.group_id.board');
            $group_board->status = 'Added';
            $group_board->deleted_at = null;
            $group_board->save();
        }

        $group_staff = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.staff'), 'status'=>'Added']);
        if ($request->input('is_staff') == 0) {
            $group_staff->delete();
        } else {
            $group_staff->contact_id = $person->id;
            $group_staff->group_id = config('polanco.group_id.staff');
            $group_staff->status = 'Added';
            $group_staff->deleted_at = null;
            $group_staff->save();
        }

        $group_steward = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.steward'), 'status'=>'Added']);
        if ($request->input('is_steward') == 0) {
            $group_steward->delete();
        } else {
            $group_steward->contact_id = $person->id;
            $group_steward->group_id = config('polanco.group_id.steward');
            $group_steward->status = 'Added';
            $group_steward->deleted_at = null;
            $group_steward->save();
        }

        $group_director = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.director'), 'status'=>'Added']);
        if ($request->input('is_director') == 0) {
            $group_director->delete();
        } else {
            $group_director->contact_id = $person->id;
            $group_director->group_id = config('polanco.group_id.director');
            $group_director->status = 'Added';
            $group_director->deleted_at = null;
            $group_director->save();
        }

        $group_innkeeper = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.innkeeper'), 'status'=>'Added']);
        if ($request->input('is_innkeeper') == 0) {
            $group_innkeeper->delete();
        } else {
            $group_innkeeper->contact_id = $person->id;
            $group_innkeeper->group_id = config('polanco.group_id.innkeeper');
            $group_innkeeper->status = 'Added';
            $group_innkeeper->deleted_at = null;
            $group_innkeeper->save();
        }

        $group_assistant = \App\Models\GroupContact::withTrashed()->firstOrNew(['contact_id'=>$person->id, 'group_id'=>config('polanco.group_id.assistant'), 'status'=>'Added']);
        if ($request->input('is_assistant') == 0) {
            $group_assistant->delete();
        } else {
            $group_assistant->contact_id = $person->id;
            $group_assistant->group_id = config('polanco.group_id.assistant');
            $group_assistant->status = 'Added';
            $group_assistant->deleted_at = null;
            $group_assistant->save();
        }

        if (null !== $request->input('agc_household_name')) {
            $agc2019 = \App\Models\Agc2019::findOrNew($person->id);
            $agc2019->contact_id = $person->id;
            $agc2019->household_name = $request->input('agc_household_name');
            $agc2019->save();
        }

        flash('Person: <a href="'.url('/person/'.$person->id).'">'.$person->display_name.'</a> updated')->success();

        return Redirect::action('PersonController@show', $person->id);
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

        // TODO: consider creating a restore/{id} or undelete/{id}
        $person = \App\Models\Contact::findOrFail($id);
        //delete existing groups and relationships when deleting user
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
        \App\Models\Contact::destroy($id);

        flash('Person: '.$person->display_name.' deleted')->warning()->important();

        return Redirect::action('PersonController@index');
    }

    public function merge_destroy($id, $return_id)
    {
        // TODO: consider creating a restore/{id} or undelete/{id}
        $this->authorize('delete-duplicate');

        $person = \App\Models\Contact::findOrFail($id);

        //delete existing groups and relationships when deleting user
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
        \App\Models\Contact::destroy($id);

        flash('Person: '.$person->sort_name.' deleted')->warning()->important();

        return Redirect::action('PersonController@merge', $return_id);
    }

    public function assistants()
    {
        return $this->role(config('polanco.group_id.assistant'));
    }

    public function bishops()
    {
        return $this->role(config('polanco.group_id.bishop'));
    }

    public function boardmembers()
    {
        return $this->role(config('polanco.group_id.board'));
    }

    public function ambassadors()
    {
        return $this->role(config('polanco.group_id.ambassador'));
    }

    public function deacons()
    {
        return $this->role(config('polanco.group_id.deacon'));
    }

    public function directors()
    {
        return $this->role(config('polanco.group_id.director'));
    }

    public function staff()
    {
        return $this->role(config('polanco.group_id.staff'));
    }

    public function innkeepers()
    {
        return $this->role(config('polanco.group_id.innkeeper'));
    }

    public function jesuits()
    {
        return $this->role(config('polanco.group_id.jesuit'));
    }

    public function pastors()
    {
        return $this->role(config('polanco.group_id.pastor'));
    }

    public function priests()
    {
        return $this->role(config('polanco.group_id.priest'));
    }

    public function provincials()
    {
        return $this->role(config('polanco.group_id.provincial'));
    }

    public function superiors()
    {
        return $this->role(config('polanco.group_id.superior'));
    }

    public function stewards()
    {
        return $this->role(config('polanco.group_id.steward'));
    }

    public function volunteers()
    {
        return $this->role(config('polanco.group_id.volunteer'));
    }

    public function role($group_id)
    {
        $this->authorize('show-contact');

        $persons = \App\Models\Contact::with('groups', 'address_primary', 'ambassador_events')->whereHas('groups', function ($query) use ($group_id) {
            $query->where('group_id', '=', $group_id)->whereStatus('Added');
        })->orderBy('sort_name')->get();

        $group = \App\Models\Group::findOrFail($group_id);
        $role['group_id'] = $group->id;
        $role['name'] = $group->name;
        $role['email_link'] = '';

        $email_list = '';
        foreach ($persons as $person) {
            if (! empty($person->email_primary_text)) {
                $email_list .= addslashes($person->display_name).' <'.$person->email_primary_text.'>,';
            }

            if (! empty($email_list)) {
                $role['email_link'] = '<a href="mailto:?bcc='.htmlspecialchars($email_list, ENT_QUOTES).'">E-mail '.$group->name.' Group</a>';
            } else {
                $role['email_link'] = null;
            }
        }

        return view('persons.role', compact('persons', 'role'));   //
    }

    /*
     * Used to get all persons with a particular relatioship type - need to work out contact_a vs contact_b
     * Similar to the role method where we can display all members of a group this will show all people with a type or relationship
     * Commented out because it is merely a work in progress to address routes like  person/retreatants

     */
    /*        public function relationship_type($relationship_type_id)
        {
            $this->authorize('show-contact');

            $persons = \App\Models\Contact::with('relationships', 'address_primary', 'ambassador_events')->whereHas('relationships', function ($query) use ($relationship_type_id) {
                $query->where('relationship_type_id', '=', $relationship_type_id)->whereIsActive(1);
            })->orderBy('sort_name')->get();

            $relationship_type = \App\RelationshipType::findOrFail($relationship_type_id);
            $relationship['relationship_type_id'] = $relationship_type->id;
            $relationship['name']= $relationship_type->description;
            $relationship['email_link']= "";

            $email_list = "";
            foreach ($persons as $person) {
                if (!empty($person->email_primary_text)) {
                    $email_list .= addslashes($person->display_name). ' <'.$person->email_primary_text.'>,';
                }

                if (!empty($email_list)) {
                    $relationship['email_link'] = "<a href=\"mailto:?bcc=".htmlspecialchars($email_list, ENT_QUOTES)."\">E-mail ".$group->name." Group</a>";
                } else {
                    $relationship['email_link'] = null;
                }
            }
            return view('persons.relationship', compact('persons', 'relationship'));   //
        }
    */

    public function save_relationship($field, $contact_id_a, $contact_id_b, $relationship_type)
    {
        $this->authorize('update-contact');
        $this->authorize('update-relationship');

        if ($request->input($field) > 0) {
            $relationship = new \App\Models\Relationship;
            $relationship->contact_id_a = $contact_id_a;
            $relationship->contact_id_b = $contact_id_b;
            $relationship->relationship_type_id = $relationship_type;
            $relationship->is_active = 1;
            $relationship->save();
        }
    }

    public function duplicates()
    {
        $this->authorize('update-contact');

        $duplicates = \App\Models\Contact::whereIn('id', function ($query) {
            $query->select('id')->from('contact')->groupBy('sort_name')->whereDeletedAt(null)->havingRaw('count(*)>1');
        })->orderBy('sort_name')->paginate(100);
        // dd($duplicates,$duplicates->total());
        return view('persons.duplicates', compact('duplicates'));
    }

    public function merge($contact_id, $merge_id = null)
    {
        $this->authorize('update-contact');
        $this->authorize('update-relationship');
        $this->authorize('update-attachment');
        $this->authorize('update-touchpoint');

        $contact = \App\Models\Contact::findOrFail($contact_id);
        $similar = \App\Models\Contact::whereSortName($contact->sort_name)->get();

        $duplicates = $similar->keyBy('id');
        $duplicates->forget($contact->id);

        //if there are no duplicates for the user go back to duplicates list
        if (! $duplicates->count()) {
            return Redirect::action('PersonController@duplicates');
        }

        if (! empty($merge_id)) {
            $merge = \App\Models\Contact::findOrFail($merge_id);
            //dd($merge);
            if ((empty($contact->prefix_id)) && (! empty($merge->prefix_id))) {
                $contact->prefix_id = $merge->prefix_id;
            }
            if (empty($contact->first_name) && ! empty($merge->first_name)) {
                $contact->first_name = $merge->first_name;
            }
            if (empty($contact->nick_name) && ! empty($merge->nick_name)) {
                $contact->nick_name = $merge->nick_name;
            }
            if (empty($contact->middle_name) && ! empty($merge->middle_name)) {
                $contact->middle_name = $merge->middle_name;
            }
            if (empty($contact->last_name) && ! empty($merge->last_name)) {
                $contact->last_name = $merge->last_name;
            }
            if (empty($contact->organization_name) && ! empty($merge->organization_name)) {
                $contact->organization_name = $merge->organization_name;
            }
            if (empty($contact->suffix_id) && ! empty($merge->suffix_id)) {
                $contact->suffix_id = $merge->suffix_id;
            }
            if (empty($contact->gender_id) && ! empty($merge->gender_id)) {
                $contact->gender_id = $merge->gender_id;
            }
            if (empty($contact->birth_date) && ! empty($merge->birth_date)) {
                $contact->birth_date = $merge->birth_date;
            }
            if (empty($contact->religion_id) && ! empty($merge->religion_id)) {
                $contact->religion_id = $merge->religion_id;
            }
            if (empty($contact->occupation_id) && ! empty($merge->occupation_id)) {
                $contact->occupation_id = $merge->occupation_id;
            }
            if (empty($contact->ethnicity_id) && ! empty($merge->ethnicity_id)) {
                $contact->ethnicity_id = $merge->ethnicity_id;
            }
            $contact->save();

            //addresses
            if (null === $contact->address_primary) {
                $contact->address_primary = new \App\Models\Address;
                $contact->address_primary->contact_id = $contact->id;
                $contact->address_primary->is_primary = 1;
            }
            if ((empty($contact->address_primary->street_address)) && (! empty($merge->address_primary->street_address))) {
                $contact->address_primary->street_address = $merge->address_primary->street_address;
            }
            if ((empty($contact->address_primary->supplemental_address_1)) && (! empty($merge->address_primary->supplemental_address_1))) {
                $contact->address_primary->supplemental_address_1 = $merge->address_primary->supplemental_address_1;
            }
            if ((empty($contact->address_primary_city)) && (! empty($merge->address_primary_city))) {
                $contact->address_primary->city = $merge->address_primary->city;
            }
            if ((empty($contact->address_primary->state_province_id)) && (! empty($merge->address_primary->state_province_id))) {
                $contact->address_primary->state_province_id = $merge->address_primary->state_province_id;
            }
            if ((empty($contact->address_primary->postal_code)) && (! empty($merge->address_primary->postal_code))) {
                $contact->address_primary->postal_code = $merge->address_primary->postal_code;
            }
            if ((empty($contact->address_primary->country_code)) && (! empty($merge->address_primary->country_code))) {
                $contact->address_primary->country_code = $merge->address_primary->country_code;
            }
            $contact->address_primary->save();

            //emergency_contact_info
            if (null === $contact->emergency_contact) {
                $contact->emergency_contact = new \App\Models\EmergencyContact;
                $contact->emergency_contact->contact_id = $contact->id;
            }

            if ((empty($contact->emergency_contact->name)) && (! empty($merge->emergency_contact->name))) {
                $contact->emergency_contact->name = $merge->emergency_contact->name;
            }
            if ((empty($contact->emergency_contact->relationship)) && (! empty($merge->emergency_contact->relationship))) {
                $contact->emergency_contact->relationship = $merge->emergency_contact->relationship;
            }
            if ((empty($contact->emergency_contact->phone)) && (! empty($merge->emergency_contact->phone))) {
                $contact->emergency_contact->phone = $merge->emergency_contact->phone;
            }
            if ((empty($contact->emergency_contact->phone_alternate)) && (! empty($merge->emergency_contact->phone_alternate))) {
                $contact->emergency_contact->phone_alternate = $merge->emergency_contact->phone_alternate;
            }
            $contact->emergency_contact->save();

            //emails
            foreach ($merge->emails as $email) {
                $contact_email = \App\Models\Email::firstOrNew(['contact_id' => $contact->id, 'location_type_id' => $email->location_type_id]);
                $contact_email->contact_id = $contact->id;
                $contact_email->location_type_id = $email->location_type_id;
                $contact_email->is_primary = $email->is_primary;
                //only create or overwrite if the current email address for the location is empty
                if (empty($contact_email->email)) {
                    $contact_email->email = $email->email;
                    $contact_email->save();
                }
            }

            //phones
            foreach ($merge->phones as $phone) {
                $contact_phone = \App\Models\Phone::firstOrNew(['contact_id' => $contact->id, 'location_type_id' => $phone->location_type_id, 'phone_type' => $phone->phone_type]);
                $contact_phone->contact_id = $contact->id;
                $contact_phone->location_type_id = $phone->location_type_id;
                $contact_phone->phone_type = $phone->phone_type;
                $contact_phone->is_primary = $phone->is_primary;
                //only create or overwrite if the current email address for the location is empty
                if (empty($contact_phone->phone)) {
                    $contact_phone->phone = $phone->phone;
                    $contact_phone->save();
                }
            }

            //notes - move all from merge to contact
            foreach ($merge->notes as $note) {
                $note->entity_id = $contact_id;
                $note->save();
            }
            //groups - move all from merge to contact
            foreach ($merge->groups as $group) {
                $group_exist = \App\Models\GroupContact::whereContactId($contact_id)->whereGroupId($group->group_id)->first();
                if (! isset($group_exist)) {
                    $group->contact_id = $contact_id;
                    $group->save();
                }
            }
            //relationships
            foreach ($merge->a_relationships as $a_relationship) {
                $a_relationship_exist = \App\Models\Relationship::whereContactIdA($contact_id)->whereContactIdB($a_relationship->contact_id_b)->whereRelationshipTypeId($a_relationship->relationship_type_id)->first();
                if (! isset($a_relationship_exist)) {
                    $a_relationship->contact_id_a = $contact_id;
                    $a_relationship->save();
                }
            }
            foreach ($merge->b_relationships as $b_relationship) {
                $b_relationship_exist = \App\Models\Relationship::whereContactIdB($contact_id)->whereContactIdA($b_relationship->contact_id_a)->whereRelationshipTypeId($b_relationship->relationship_type_id)->first();
                if (! isset($b_relationship_exist)) {
                    $b_relationship->contact_id_b = $contact_id;
                    $b_relationship->save();
                }
            }
            //touchpoints
            foreach ($merge->touchpoints as $touchpoint) {
                $touchpoint->person_id = $contact_id;
                $touchpoint->save();
            }
            //attachments
            foreach ($merge->attachments as $attachment) {
                $path = 'contact/'.$merge_id.'/attachments/'.$attachment->uri;
                $newpath = 'contact/'.$contact_id.'/attachments/'.$attachment->uri;
                //check for avatar.png and move appropriately otherwise move the attachment
                if ($attachment->uri == 'avatar.png') {
                    $path = 'contact/'.$merge_id.'/'.$attachment->uri;
                    $newpath = 'contact/'.$contact_id.'/'.$attachment->uri;
                }
                Storage::move($path, $newpath);
                $attachment->entity_id = $contact->id;
                $attachment->save();
            }
            //event registrations
            foreach ($merge->event_registrations as $registration) {
                $registration->contact_id = $contact_id;
                $registration->save();
            }
            //event registrations
            foreach ($merge->donations as $donation) {
                $donation->contact_id = $contact_id;
                $donation->save();
            }
            // only show flash after a successful merge
            flash('Contact ID#: '.$merge_id.' merged with Contact ID#: '.$contact_id)->warning()->important();
        }

        return view('persons.merge', compact('contact', 'duplicates'));
    }
}

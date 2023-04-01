<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSquarespaceOrderRequest;
use App\Mail\GiftCertificateRedemption;
use App\Mail\SquarespaceOrderFulfillment;
use App\Models\Address;
use App\Models\Contact;
use App\Models\ContactLanguage;
use App\Models\Country;
use App\Models\Donation;
use App\Models\Email;
use App\Models\EmergencyContact;
use App\Models\GiftCertificate;
use App\Models\Language;
use App\Models\Note;
use App\Models\Payment;
use App\Models\Phone;
use App\Models\Prefix;
use App\Models\Registration;
use App\Models\Relationship;
use App\Models\Retreat;
use App\Models\SquarespaceOrder;
use App\Models\StateProvince;
use App\Models\Touchpoint;
use App\Traits\SquareSpaceTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class SquarespaceOrderController extends Controller
{
    use SquareSpaceTrait;

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
        $this->authorize('show-squarespace-order');
        $unprocessed_orders = SquarespaceOrder::whereIsProcessed(0)->orderBy('order_number')->paginate(25, ['*'], 'unprocessed_orders');
        $processed_orders = SquarespaceOrder::whereIsProcessed(1)->orderByDesc('order_number')->paginate(25, ['*'], 'processed_orders');

        return view('squarespace.order.index', compact('unprocessed_orders', 'processed_orders'));
    }

    /**
     * Squarespace orders are created from parsed Mailgun messages
     * Hence, the create method is an empty slug
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //use permisson of target, namely squarespace.order.index
        $this->authorize('show-squarespace-order');

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Squarespace orders are created from parsed Mailgun messages
     * Hence, the store method is an empty slug
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //use permisson of target, namely squarespace.order.index
        $this->authorize('show-squarespace-order');

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
        $this->authorize('show-squarespace-order');
        $order = SquarespaceOrder::findOrFail($id);

        return view('squarespace.order.show', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_order_number($order_number)
    {
        $this->authorize('show-squarespace-order');
        $order = SquarespaceOrder::whereOrderNumber($order_number)->first();

        return view('squarespace.order.show', compact('order'));
    }

    /**
     * Show an order to confirm the retreatant for a SquareSpace order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-squarespace-order');
        $order = SquarespaceOrder::findOrFail($id);
        $gift_certificate = (empty($order->gift_certificate_id)) ? null : GiftCertificate::findOrFail($order->gift_certificate_id);
        $prefixes = Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('None', null);
        $states = StateProvince::orderBy('abbreviation')->whereCountryId(config('polanco.country_id_usa'))->pluck('abbreviation', 'id');
        $states->prepend('N/A', null);
        $countries = Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', null);
        $religions = \App\Models\Religion::orderBy('name')->whereIsActive(1)->pluck('name', 'id');
        $religions->prepend('N/A', 0);
        $genders = \App\Models\Gender::orderBy('name')->pluck('name', 'id');
        $genders->prepend('N/A', 0);
        $languages = Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('None', null);
        $parishes = Contact::whereSubcontactType(config('polanco.contact_type.parish'))->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        $parish_list[0] = 'N/A';
        $prefix = Prefix::whereName($order->title)->first();
        $couple_prefix = Prefix::whereName($order->couple_title)->first();
        $state = (strlen($order->address_state) > 2) ?
                StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereName(strtoupper($order->address_state))->first() :
                StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereAbbreviation(strtoupper($order->address_state))->first();
        //dd($order, $state);
        $order->preferred_language = ($order->preferred_language == 'Inglés') ? 'English' : $order->preferred_language;
        $order->preferred_language = ($order->preferred_language == 'Español') ? 'Spanish' : $order->preferred_language;
        $order->preferred_language = ($order->preferred_language == 'Vietnamita') ? 'Vietnamese' : $order->preferred_language;
        $language = Language::whereIsActive(1)->where('label', 'LIKE', $order->preferred_language.'%')->first();

        // attempt to find retreat based on event_id if available or retreat_idnumber
        if ($order->event_id > 0) {
            $retreat = Retreat::findOrFail($order->event_id);
        } else {
            $retreat = Retreat::whereIdnumber($order->retreat_idnumber)->first();
        }

        $send_fulfillment = 0; //initialize to false
        if (! empty($retreat->id)) {
            $send_fulfillment = (($retreat->capacity_percentage < 90) && ($retreat->days_until_start > 8)) ? 1 : 0;
        }

        $ids = [];
        $ids['title'] = ($prefix == null) ? null : $prefix->id;
        $ids['couple_title'] = ($couple_prefix == null) ? null : $couple_prefix->id;
        $ids['preferred_language'] = ($language == null) ? null : $language->id;
        $ids['address_state'] = (isset($state->id)) ? $state->id : null;
        $ids['address_country'] = config('polanco.country_id_usa'); // assume US
        $ids['retreat_id'] = isset($retreat->id) ? $retreat->id : null;

        // while probably not the most efficient way of doing this it gets me the result
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }

        $retreats = $this->upcoming_retreats($order->event_id);
        // ensure contact_id is part of matching_contacts but if not then add it
        $matching_contacts = $this->matched_contacts($order);
        if (! array_key_exists($order->contact_id, $matching_contacts) && isset($order->contact_id)) {
            $matching_contacts[$order->contact_id] = $order->retreatant->full_name_with_city;
        }

        $couple = collect([]);
        $couple->name = $order->couple_name;
        $couple->email = $order->couple_email;
        $couple->mobile_phone = $order->couple_mobile_phone;
        $couple->full_address = $order->full_address;
        $couple->date_of_birth = $order->couple_date_of_birth;
        $couple_matching_contacts = (isset($order->couple_name)) ? $this->matched_contacts($couple) : [null => 'No name provided'];
        //dd($couple_matching_contacts, $matching_contacts);

        return view('squarespace.order.edit', compact('order', 'matching_contacts', 'retreats', 'couple_matching_contacts', 'prefixes', 'states', 'countries', 'languages', 'parish_list', 'ids', 'genders', 'religions', 'send_fulfillment', 'gift_certificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSquarespaceOrderRequest $request, $id)
    {
        $order = SquarespaceOrder::findOrFail($id);
        $gift_certificate = (empty($order->gift_certificate_full_number)) ? null : GiftCertificate::findOrFail($order->gift_certificate_id);
        $contact_id = $request->input('contact_id');
        $couple_contact_id = $request->input('couple_contact_id');

        $event_id = $request->input('event_id'); // keep in mind that for gift certificates there is no event_id
        if (isset($event_id)) {
            $event = Retreat::findOrFail($event_id);
        }

        // always update any data changes in order
        $order->order_number = ($request->filled('order_number')) ? $request->input('order_number') : $order->order_number;
        $order->title = ($request->filled('title')) ? $request->input('title') : $order->title;
        $order->couple_title = $request->input('couple_title');
        $order->name = ($request->filled('name')) ? $request->input('name') : $order->name;
        $order->couple_name = ($request->filled('couple_name')) ? $request->input('couple_name') : $order->couple_name;
        $order->email = $request->input('email');
        $order->couple_email = $request->input('couple_email');
        $order->mobile_phone = $request->input('mobile_phone');
        $order->couple_mobile_phone = $request->input('couple_mobile_phone');
        $order->home_phone = $request->input('home_phone');
        $order->work_phone = $request->input('work_phone');
        $order->address_street = $request->input('address_street');
        $order->address_supplemental = $request->input('address_supplemental');
        $order->address_city = $request->input('address_city');
        $state = ($request->filled('address_state_id')) ? StateProvince::findOrFail(($request->input('address_state_id'))) : null;
        $order->address_state = (null !== optional($state)->abbreviation) ? optional($state)->abbreviation : $order->address_state;
        $order->address_zip = $request->input('address_zip');
        $country = ($request->filled('address_country_id')) ? Country::findOrFail(($request->input('address_country_id'))) : null;
        $order->address_country = (null !== optional($country)->iso_code) ? optional($country)->iso_code : $order->address_country;
        $order->dietary = $request->input('dietary');
        $order->couple_dietary = $request->input('couple_dietary');
        $order->date_of_birth = $request->input('date_of_birth');
        $order->couple_date_of_birth = $request->input('couple_date_of_birth');
        $order->room_preference = $request->input('room_preference');

        $preferred_language = ($request->filled('preferred_language_id')) ? Language::findOrFail($request->input('preferred_language_id')) : null;
        $order->preferred_language = (null !== optional($preferred_language)->label) ? optional($preferred_language)->label : $order->preferred_language;
        $english_language = Language::whereName('en_US')->first();

        if (isset($preferred_language)) {
            $spoken_language = ContactLanguage::firstOrCreate([
                'contact_id' => $contact_id,
                'language_id' => $preferred_language->id,
            ]);
        }

        // assumes that all users speak Engilsh
        $spoken_language = ContactLanguage::firstOrCreate([
            'contact_id' => $contact_id,
            'language_id' => $english_language->id,
        ]);

        // $order->parish_id = $request->input('parish_id');
        $order->emergency_contact = $request->input('emergency_contact');
        $order->emergency_contact_relationship = $request->input('emergency_contact_relationship');
        $order->emergency_contact_phone = $request->input('emergency_contact_phone');
        $order->couple_emergency_contact = $request->input('couple_emergency_contact');
        $order->couple_emergency_contact_relationship = $request->input('couple_emergency_contact_relationship');
        $order->couple_emergency_contact_phone = $request->input('couple_emergency_contact_phone');
        $order->deposit_amount = ($request->filled('deposit_amount')) ? $request->input('deposit_amount') : 0;
        $order->additional_names_and_phone_numbers = $request->input('additional_names_and_phone_numbers');
        $order->event_id = $event_id;
        $order->save();
        // dd($order, $contact_id, $order->is_couple, $couple_contact_id);
        if ($order->is_processed) { // the order has already been processed
            flash('<a href="'.url('/squarespace/order/'.$order->id).'">'.$order->order_description.'</a> has already been processed')->error()->important();

            return Redirect::action([self::class, 'index']);
        } else { // the order has not been processed
            if (! isset($order->participant_id) && (! isset($order->contact_id) || ($order->is_couple && ! isset($order->couple_contact_id)))) {
                if ($contact_id == 0) {
                    // Create a new contact
                    $contact = new Contact;
                    $contact->contact_type = config('polanco.contact_type.individual');
                    $contact->subcontact_type = 0;
                    $contact->first_name = $request->input('first_name');
                    $contact->middle_name = $request->input('middle_name');
                    $contact->last_name = $request->input('last_name');
                    $contact->nick_name = $request->input('nick_name');
                    $contact->sort_name = $request->input('last_name').', '.$request->input('first_name');
                    $contact->display_name = $request->input('first_name').' '.$request->input('last_name');
                    $contact->save();
                    $contact_id = $contact->id;
                    $order->contact_id = $contact->id;
                } else {
                    $contact = Contact::findOrFail($contact_id);
                    $order->contact_id = $contact->id;
                }

                if ($order->is_couple) {
                    if ($couple_contact_id == 0 && ! isset($order->couple_contact_id)) {
                        // Create a new couple contact
                        $couple_contact = new Contact;
                        $couple_contact->contact_type = config('polanco.contact_type.individual');
                        $couple_contact->subcontact_type = 0;
                        $couple_contact->first_name = $request->input('couple_first_name');
                        $couple_contact->middle_name = $request->input('couple_middle_name');
                        $couple_contact->last_name = $request->input('couple_last_name');
                        $couple_contact->nick_name = $request->input('couple_nick_name');
                        $couple_contact->sort_name = $request->input('couple_last_name').', '.$request->input('couple_first_name');
                        $couple_contact->display_name = $request->input('couple_first_name').' '.$request->input('couple_last_name');
                        $couple_contact->save();
                        $couple_contact_id = $couple_contact->id;
                        $order->couple_contact_id = $couple_contact->id;
                    } else {
                        $couple_contact = Contact::findOrFail($couple_contact_id);
                        $order->couple_contact_id = $couple_contact->id;
                    }
                }
                $order->save();

                return Redirect::action([self::class, 'edit'], ['order' => $id]);
            }

            // process order: we have contact_id and event_id (unless it is a gift certificate) but not participant_id and not processed
            // update contact info (prefix, parish, )

            $contact = Contact::findOrFail($contact_id);

            $contact->prefix_id = ($request->filled('title_id')) ? $request->input('title_id') : $contact->prefix_id;
            $contact->first_name = ($request->filled('first_name')) ? $request->input('first_name') : $contact->first_name;
            $contact->middle_name = ($request->filled('middle_name')) ? $request->input('middle_name') : $contact->middle_name;
            $contact->last_name = ($request->filled('last_name')) ? $request->input('last_name') : $contact->last_name;
            $contact->nick_name = ($request->filled('nick_name')) ? $request->input('nick_name') : $contact->nick_name;
            $contact->birth_date = ($request->filled('date_of_birth')) ? $request->input('date_of_birth') : $contact->birth_date;
            $contact->gender_id = $request->input('gender_id');
            $contact->religion_id = $request->input('religion_id');
            $contact->preferred_language = (isset(optional($preferred_language)->name)) ? $preferred_language->name : null;
            $contact->save();
            // save room_preference
            $room_preference = Note::firstOrNew([
                'entity_table' => 'contact',
                'entity_id' => $contact_id,
                'subject' => 'Room Preference',
            ]);
            $room_preference->note = $request->filled('room_preference') ? $request->input('room_preference') : $room_preference->note;
            $room_preference->save();

            // save parish
            if ($request->input('parish_id') > 0) {
                $relationship_parishioner = Relationship::firstOrNew([
                    'contact_id_b' => $contact_id,
                    'relationship_type_id' => config('polanco.relationship_type.parishioner'),
                    'is_active' => 1,
                ]);
                $relationship_parishioner->contact_id_a = $request->input('parish_id');
                $relationship_parishioner->save();
            }
            //TODO: when updating order, change parish name to the display name of the parish

            // retreatant relationship
            $relationship_retreatant = Relationship::firstOrNew([
                'contact_id_a' => config('polanco.self.id'),
                'contact_id_b' => $contact_id,
                'relationship_type_id' => config('polanco.relationship_type.retreatant'),
                'is_active' => 1,
            ]);
            $relationship_retreatant->save();

            // donor relationship
            $relationship_donor = Relationship::firstOrNew([
                'contact_id_a' => config('polanco.self.id'),
                'contact_id_b' => $contact_id,
                'relationship_type_id' => config('polanco.relationship_type.donor'),
                'is_active' => 1,
            ]);
            $relationship_donor->save();

            $email_home = Email::firstOrNew([
                'contact_id' => $contact_id,
                'location_type_id' => config('polanco.location_type.home')]);
            // $request->input('primary_email_location_id') == config('polanco.location_type.home') ? $email_home->is_primary = 1 : $email_home->is_primary = 0;
            $email_home->email = ($request->filled('email')) ? $request->input('email') : $email_home->email;
            $email_home->is_primary = ($contact->primary_email_location_type_id == config('polanco.location_type.home')) ? 1 : 0;
            // if there is no current primary email then make this one the primary one
            $email_home->is_primary = ($contact->primary_email_location_name == 'N/A') ? 1 : $email_home->is_primary;
            $email_home->save();

            // because of how the phone_ext field is handled by the model, reset to null on every update to ensure it gets removed and then re-added during the update
            $phone_home_mobile = Phone::firstOrNew([
                'contact_id' => $contact_id,
                'location_type_id' => config('polanco.location_type.home'),
                'phone_type' => 'Mobile']);
            $phone_home_mobile->phone_ext = null;
            // if mobile_phone is primary leave it as such
            $phone_home_mobile->is_primary = ($contact->primary_phone_location_type_id == config('polanco.location_type.home') && $contact->primary_phone_type == 'Mobile') ? 1 : 0;
            // if there is not primary phone then make home:mobile the primary one otherwise do nothing (use existing primary)
            $phone_home_mobile->is_primary = ($contact->primary_phone_location_name == 'N/A' && $contact->primary_phone_type == null) ? 1 : $phone_home_mobile->is_primary;
            $phone_home_mobile->phone = ($request->filled('mobile_phone')) ? $request->input('mobile_phone') : $phone_home_mobile->phone;
            $phone_home_mobile->save();

            $phone_home_phone = Phone::firstOrNew([
                'contact_id' => $contact_id,
                'location_type_id' => config('polanco.location_type.home'),
                'phone_type' => 'Phone']);
            $phone_home_phone->phone_ext = null;
            $phone_home_phone->is_primary = (($contact->primary_phone_location_type_id == config('polanco.location_type.home') && $contact->primary_phone_type == 'Phone')) ? 1 : 0;
            $phone_home_phone->phone = ($request->filled('home_phone')) ? $request->input('home_phone') : $phone_home_phone->phone;
            $phone_home_phone->save();

            $phone_work_phone = Phone::firstOrNew([
                'contact_id' => $contact_id,
                'location_type_id' => config('polanco.location_type.work'),
                'phone_type' => 'Phone',
            ]);
            $phone_work_phone->phone_ext = null;
            $phone_work_phone->is_primary = ($contact->primary_phone_location_type_id == config('polanco.location_type.work') && $contact->primary_phone_type == 'Phone') ? 1 : 0;
            $phone_work_phone->phone = ($request->filled('work_phone')) ? $request->input('work_phone') : $phone_work_phone->phone;
            $phone_work_phone->save();

            $home_address = Address::firstOrNew([
                'contact_id' => $contact_id,
                'location_type_id' => config('polanco.location_type.home'),
            ]);
            $home_address->street_address = ($request->filled('address_street')) ? $request->input('address_street') : $home_address->street_address;
            $home_address->supplemental_address_1 = ($request->filled('address_supplemental')) ? $request->input('address_supplemental') : $home_address->supplemental_address_1;
            $home_address->city = ($request->filled('address_city')) ? $request->input('address_city') : $home_address->city;
            $home_address->state_province_id = ($request->filled('address_state_id')) ? $request->input('address_state_id') : $home_address->state_province_id;
            $home_address->postal_code = ($request->filled('address_zip')) ? $request->input('address_zip') : $home_address->postal_code;
            $home_address->country_id = ($request->filled('address_country_id')) ? $request->input('address_country_id') : $home_address->country_id;
            $home_address->is_primary = ($contact->primary_address_location_type_id == config('polanco.location_type.home')) ? 1 : 0;
            // if there is no current primary address then make this one the primary one
            $home_address->is_primary = ($contact->primary_address_location_name == 'N/A') ? 1 : $home_address->is_primary;
            $home_address->save();

            // create dietary note
            $person_note_dietary = Note::firstOrNew([
                'entity_table' => 'contact',
                'entity_id' => $contact->id,
                'subject' => 'Dietary Note',
            ]);
            $person_note_dietary->note = ($request->filled('dietary')) ? $request->input('dietary') : $person_note_dietary->note;
            $person_note_dietary->save();

            // create health note
            $person_note_health = Note::firstOrNew([
                'entity_table' => 'contact',
                'entity_id' => $contact_id,
                'subject' => 'Health Note',
            ]);
            $person_note_health->note = ($request->filled('health')) ? $request->input('health') : $person_note_health->note;
            $person_note_health->save();

            //emergency contact info
            $emergency_contact = EmergencyContact::firstOrNew([
                'contact_id' => $contact_id,
            ]);
            $emergency_contact->name = ($request->filled('emergency_contact')) ? $request->input('emergency_contact') : $emergency_contact->name;
            $emergency_contact->relationship = ($request->filled('emergency_contact_relationship')) ? $request->input('emergency_contact_relationship') : $emergency_contact->relationship;
            $emergency_contact->phone = ($request->filled('emergency_contact_phone')) ? $request->input('emergency_contact_phone') : $emergency_contact->phone;
            $emergency_contact->save();

            if (isset($couple_contact_id)) {
                $couple_contact = Contact::findOrFail($couple_contact_id);
                $couple_contact->prefix_id = ($request->filled('couple_title_id')) ? $request->input('couple_title_id') : $couple_contact->prefix_id;
                $couple_contact->first_name = ($request->filled('couple_first_name')) ? $request->input('couple_first_name') : $couple_contact->first_name;
                $couple_contact->middle_name = ($request->filled('couple_middle_name')) ? $request->input('couple_middle_name') : $couple_contact->middle_name;
                $couple_contact->last_name = ($request->filled('couple_last_name')) ? $request->input('couple_last_name') : $couple_contact->last_name;
                $couple_contact->nick_name = ($request->filled('couple_nick_name')) ? $request->input('couple_nick_name') : $couple_contact->nick_name;
                $couple_contact->birth_date = ($request->filled('couple_date_of_birth')) ? $request->input('couple_date_of_birth') : $couple_contact->birth_date;
                $couple_contact->gender_id = $request->input('couple_gender_id');
                $couple_contact->religion_id = $request->input('couple_religion_id');
                $couple_contact->save();

                $spoken_language = ContactLanguage::firstOrCreate([
                    'contact_id' => $couple_contact_id,
                    'language_id' => $english_language->id,
                ]);

                // retreatant relationship
                $couple_relationship_retreatant = Relationship::firstOrNew([
                    'contact_id_a' => config('polanco.self.id'),
                    'contact_id_b' => $couple_contact_id,
                    'relationship_type_id' => config('polanco.relationship_type.retreatant'),
                    'is_active' => 1,
                ]);
                $couple_relationship_retreatant->save();

                $couple_email_home = Email::firstOrNew([
                    'contact_id' => $couple_contact_id,
                    'location_type_id' => config('polanco.location_type.home')]);
                $couple_email_home->is_primary = ($couple_contact->primary_email_location_name == config('polanco.location_type.home')) ? 1 : 0;
                // if there is no current primary email then make this one the primary one
                $couple_email_home->is_primary = ($couple_contact->primary_email_location_name == 'N/A') ? 1 : $couple_email_home->is_primary;
                $couple_email_home->email = ($request->filled('couple_email')) ? $request->input('couple_email') : $couple_email_home->email;
                $couple_email_home->save();

                // because of how the phone_ext field is handled by the model, reset to null on every update to ensure it gets removed and then re-added during the update
                $couple_phone_home_mobile = Phone::firstOrNew([
                    'contact_id' => $couple_contact_id,
                    'location_type_id' => config('polanco.location_type.home'),
                    'phone_type' => 'Mobile']);
                $couple_phone_home_mobile->phone_ext = null;
                // if mobile_phone is primary leave it as such
                $couple_phone_home_mobile->is_primary = ($couple_contact->primary_phone_location_type_id == config('polanco.location_type.home') && $couple_contact->primary_phone_type == 'Mobile') ? 1 : 0;
                // if there is not primary phone then make home:mobile the primary one otherwise do nothing (use existing primary)
                $couple_phone_home_mobile->is_primary = ($couple_contact->primary_phone_location_name == 'N/A' && $couple_contact->primary_phone_type == null) ? 1 : $couple_phone_home_mobile->is_primary;
                $couple_phone_home_mobile->phone = ($request->filled('couple_mobile_phone')) ? $request->input('couple_mobile_phone') : $couple_phone_home_mobile->phone;
                $couple_phone_home_mobile->save();

                if (! $order->is_gift_certificate) { // skip if this is a gift certificate
                    $couple_home_address = Address::firstOrNew([
                        'contact_id' => $couple_contact_id,
                        'location_type_id' => config('polanco.location_type.home'),
                    ]);
                    $couple_home_address->street_address = ($request->filled('address_street')) ? $request->input('address_street') : $couple_home_address->street_address;
                    $couple_home_address->supplemental_address_1 = ($request->filled('address_supplemental')) ? $request->input('address_supplemental') : $couple_home_address->supplemental_address_1;
                    $couple_home_address->city = ($request->filled('address_city')) ? $request->input('address_city') : $couple_home_address->city;
                    $couple_home_address->state_province_id = ($request->filled('address_state_id')) ? $request->input('address_state_id') : $couple_home_address->state_province_id;
                    $couple_home_address->postal_code = ($request->filled('address_zip')) ? $request->input('address_zip') : $couple_home_address->postal_code;
                    $couple_home_address->country_id = ($request->filled('address_country_id')) ? $request->input('address_country_id') : $couple_home_address->country_id;
                    $couple_home_address->is_primary = ($couple_contact->primary_address_location_type_id == config('polanco.location_type.home')) ? 1 : 0;
                    // if there is no current primary address then make this one the primary one
                    $couple_home_address->is_primary = ($couple_contact->primary_address_location_name == 'N/A') ? 1 : $couple_home_address->is_primary;
                    $couple_home_address->save();
                }

                // couple emergency contact info
                $couple_emergency_contact = EmergencyContact::firstOrNew([
                    'contact_id' => $couple_contact_id,
                ]);
                $couple_emergency_contact->name = ($request->filled('couple_emergency_contact')) ? $request->input('couple_emergency_contact') : $couple_emergency_contact->name;
                $couple_emergency_contact->relationship = ($request->filled('couple_emergency_contact_relationship')) ? $request->input('couple_emergency_contact_relationship') : $couple_emergency_contact->relationship;
                $couple_emergency_contact->phone = ($request->filled('couple_emergency_contact_phone')) ? $request->input('couple_emergency_contact_phone') : $couple_emergency_contact->phone;
                $couple_emergency_contact->save();

                // if this is for a gift certificate - let's create the gift cerfificate so we have the number available moving forward
                if ($order->is_gift_certificate) {
                    $gift_certificate = new \App\Models\GiftCertificate;
                    $gift_certificate->purchaser_id = $order->contact_id;
                    $gift_certificate->recipient_id = $order->couple_contact_id;
                    $gift_certificate->squarespace_order_number = $order->order_number;
                    $gift_certificate->purchase_date = $order->created_at;
                    $gift_certificate->issue_date = $order->created_at;
                    $expiration_date = $order->created_at->addYear()->addDay();
                    $gift_certificate->expiration_date = $expiration_date;
                    $gift_certificate->funded_amount = $order->unit_price;

                    $gift_certificate->save();
                    $gift_certificate->update_pdf();
                    $order->gift_certificate_number = $gift_certificate->certificate_number;
                }

                // create couple touchpoint
                $touchpoint = new Touchpoint;
                $touchpoint->person_id = $couple_contact_id;
                $touchpoint->staff_id = config('polanco.self.id');
                $touchpoint->type = 'Other';
                $touchpoint->notes = ($order->is_gift_certificate) ?
                    'Squarespace Order #'.$order->order_number.' - Gift certificate #'.$order->gift_certificate_number.' received from '.$contact->display_name :
                    'Squarespace Order #'.$order->order_number.' received from spouse, '.$contact->display_name;
                $touchpoint->touched_at = Carbon::now();
                $touchpoint->save();

                // create registration (record deposit, comments, squarespaceorder_number)
                if (isset($event_id) && ! $order->is_gift_certificate) {
                    $registration = Registration::firstOrNew([
                        'contact_id' => $couple_contact_id,
                        'event_id' => $event_id,
                        'order_id' => $order->id,
                        'role_id' => config('polanco.participant_role_id.retreatant'),
                    ]);
                    $registration->source = 'Squarespace';
                    $registration->register_date = $order->created_at;
                    $registration->deposit = ($request->filled('deposit_amount')) ? ($request->input('deposit_amount') / 2) : 0;
                    $registration->status_id = config('polanco.registration_status_id.registered');
                    $registration->notes = $order->order_description.'. '.$request->input('comments');
                    $registration->remember_token = Str::random(60);
                    $registration->save();
                }
            }

            // TODO: if couple - check if the relationship exists and if not create it (remember, gift certificates may or may not be from a spouse)

            // create touchpoint for traditional order otherwise we are dealing with a gift certificate being used
            $touchpoint = new Touchpoint;
            $touchpoint->person_id = $contact_id;
            $touchpoint->staff_id = config('polanco.self.id');
            $touchpoint->type = 'Other';
            $touchpoint->notes = $order->order_description.' received from '.$contact->display_name;
            $touchpoint->touched_at = Carbon::now();
            $touchpoint->save();

            // create registration (record deposit, comments, squarespaceorder_number)
            if (isset($event_id) && ! $order->is_gift_certificate) {
                $registration = Registration::firstOrNew([
                    'contact_id' => $contact_id,
                    'event_id' => $event_id,
                    'order_id' => $order->id,
                    'role_id' => config('polanco.participant_role_id.retreatant'),
                ]);
                $registration->source = 'Squarespace';
                $registration->register_date = $order->created_at;
                $registration->status_id = config('polanco.registration_status_id.registered');
                $registration->remember_token = Str::random(60);
                $registration->notes = $order->order_description;
                if (! isset($order->gift_certificate_full_number)) {
                    // if couple split the deposit between them
                    $registration->deposit = ($order->is_couple) ? ($request->input('deposit_amount') / 2) : $request->input('deposit_amount');
                    $registration->deposit = (! isset($registration->deposit)) ? 0 : $registration->deposit;
                } else { // gift certificate redemption - no deposit
                    $registration->deposit = 0;
                }
                $registration->save();

                // registration and touchpoint will link to the primary retreatant (not the spouse)
                $order->participant_id = $registration->id;
                $order->touchpoint_id = $touchpoint->id;

                // gift certificate redemption
                if (! empty($order->gift_certificate_id)) {
                    $gift_certificate = GiftCertificate::find($order->gift_certificate_id);
                    $gift_certificate->participant_id = $registration->id;
                    $gift_certificate->save();
                }

//                dd($request->input('send_fulfillment'), $request->filled('email'), $tmp );
                if ($request->input('send_fulfillment') && $request->filled('email')) {
                    // generate email
                    try {
                        Mail::to($request->input('email'))->send(new SquarespaceOrderFulfillment($order));
                    } catch (\Exception $e) { //failed to send finance notification of event_id change on registration
                        flash('Error sending Squarespace Order Fulfillment Email for '.$order->order_description.': <a href="'.url('/squarespace/order/'.$order->id).'">'.$order->order_description.'</a>')->warning();
                    }
                    flash('Fulfillment Email sent for: <a href="'.url('/squarespace/order/'.$order->id).'">'.$order->order_description.'</a>')->success();
                    // create touchpoint
                    $touchpoint = new Touchpoint;
                    $touchpoint->person_id = $contact_id;
                    $touchpoint->staff_id = config('polanco.self.id');
                    $touchpoint->type = 'Email';
                    $touchpoint->notes = 'Fulfillment email for '.$order->order_description;
                    $touchpoint->touched_at = Carbon::now();
                    $touchpoint->save();
                }
            }

            $order->is_processed = 1;
            $order->save();

            // create donation(s) (record deposit as donation (with no payment), notes)
            $donation = new Donation;
            $donation->contact_id = $contact_id;

            if ($order->is_gift_certificate) {
                $donation->donation_description = 'Gift Certificates - Funded';
                $donation->donation_date = $order->created_at;
                $donation->donation_amount = $order->unit_price;
                $donation->squarespace_order = $order->order_number;
                $donation->Notes = 'SS Order #'.$order->order_number.' for Gift Certificate #'.$order->gift_certificate_number.' gifted to '.$couple_contact->display_name;
                $donation->save();
                $order->donation_id = $donation->donation_id;
                if (isset($gift_certificate)) {
                    $gift_certificate->donation_id = $donation->donation_id;
                    $gift_certificate->save();
                }
            } else {
                if (! empty($order->gift_certificate_id)) { //gift certificate redemption
                    $gift_certificate = GiftCertificate::find($order->gift_certificate_id);
                    if (! empty(optional($gift_certificate)->donation_id)) {
                        $gift_certificate_donation = Donation::find($gift_certificate->donation_id);
                        $amount_reallocated = $gift_certificate_donation->donation_amount;
                        // create reallocation payments and adjust purchaser donation_amount to zero
                        $negative_reallocation_payment = new Payment;
                        $negative_reallocation_payment->donation_id = $gift_certificate_donation->donation_id;
                        $negative_reallocation_payment->payment_amount = -($gift_certificate_donation->donation_amount);
                        $negative_reallocation_payment->payment_description = 'Reallocation';
                        $negative_reallocation_payment->note = 'Gift certificate #'.$gift_certificate->certificate_number.' redeemed by '.optional($gift_certificate->recipient)->display_name.' applied to Retreat #'.$gift_certificate->registration->event_id_number;
                        $negative_reallocation_payment->payment_date = now();
                        $negative_reallocation_payment->save();
                        $gift_certificate_donation->donation_amount = $gift_certificate_donation->donation_amount + $negative_reallocation_payment->payment_amount;
                        $gift_certificate_donation->Notes = 'Donation amount updated for Gift Certificate: '.$gift_certificate->certificate_number.' redemption. '.$gift_certificate_donation->Notes;
                        $gift_certificate_donation->save();
                        // create retreat deposit donation for recipient
                        $donation->event_id = $event_id;
                        $donation->donation_description = 'Retreat Deposits';
                        $donation->donation_date = $order->event->start_date;
                        $donation->donation_amount = $amount_reallocated;
                        $donation->squarespace_order = $gift_certificate->certificate_number;
                        $donation->Notes = $order->order_description.' applied to Retreat #'.$order->event->idnumber;
                        $donation->save();
                        $reallocation_payment = new Payment;
                        $reallocation_payment->donation_id = $donation->donation_id;
                        $reallocation_payment->payment_amount = $donation->donation_amount;
                        $reallocation_payment->payment_description = 'Reallocation';
                        $reallocation_payment->note = 'Gift certificate #'.$gift_certificate->certificate_number.' purchased by '.optional($gift_certificate->purchaser)->display_name.' applied to Retreat #'.$gift_certificate->registration->event_id_number;
                        $reallocation_payment->payment_date = $negative_reallocation_payment->payment_date;
                        $reallocation_payment->save();
                        flash('Donation/Payment Reallocations processed for Gift Certificate #<a href="'.url('/gift_certificate/'.$gift_certificate->id).'">'.$gift_certificate->certificate_number.'</a>')->success();

                        // if finance notification is enabled
                        // and if it is a funded gift certificate
                        if (config('polanco.notify_registration_event_change') && $gift_certificate->funded_amount > 0) {
                            $finance_email = config('polanco.finance_email');
                            try {
                                Mail::to($finance_email)->send(new GiftCertificateRedemption($gift_certificate, $order, $negative_reallocation_payment, $reallocation_payment));
                            } catch (\Exception $e) { //failed to send finance notification of gift certificate redemption
                                // dd($e);
                                flash('Email notification NOT sent to finance regarding Gift Certificate Redepmtion for #: <a href="'.url('/gift_certificate/'.$gift_certificate->id).'">'.$gift_certificate->certificate_number.'</a>')->warning();
                            }
                            if (empty($e)) {
                                flash('Email notification sent to finance regarding Gift Certificate Redemption #: <a href="'.url('/gift_certificate/'.$gift_certificate->id).'">'.$gift_certificate->certificate_number.'</a>')->success();
                            }
                        }
                    }
                } else { // add regular retreat registration deposit
                    $donation->event_id = $event_id;
                    $donation->donation_description = 'Retreat Deposits';
                    $donation->donation_date = $order->event->start_date;
                    $donation->donation_amount = ($order->is_couple) ? ($order->deposit_amount / 2) : $order->deposit_amount;
                    $donation->squarespace_order = $order->order_number;
                    $donation->Notes = $order->order_description.' for Retreat #'.$order->event->idnumber;
                    $donation->save();
                    $order->donation_id = $donation->donation_id;

                    if ($order->is_couple && isset($order->couple_contact_id)) {
                        $couple_donation = new Donation;
                        $couple_donation->contact_id = $order->couple_contact_id;
                        $couple_donation->event_id = $event_id;
                        $couple_donation->donation_description = 'Retreat Deposits';
                        $couple_donation->donation_date = $order->event->start_date;
                        $couple_donation->donation_amount = ($order->is_couple) ? ($order->deposit_amount / 2) : $order->deposit_amount;
                        $couple_donation->squarespace_order = $order->order_number;
                        $couple_donation->Notes = $order->order_description.' for Retreat #'.$order->event->idnumber;
                        $couple_donation->save();
                        $order->couple_donation_id = $couple_donation->donation_id;
                    }
                }
            }

            $order->save();
            flash('<a href="'.url('/squarespace/order/'.$order->id).'">'.$order->order_description.'</a> processed')->success();

            return Redirect::action([self::class, 'index']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //use permisson of target, namely squarespace.order.index
        $this->authorize('show-squarespace-order');

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Reset to re-select the retreatant for a SquareSpace order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset($id)
    {
        $this->authorize('update-squarespace-order');

        $order = SquarespaceOrder::findOrFail($id);
        $order->contact_id = null;
        $order->save();

        return Redirect::action([self::class, 'edit'], ['order' => $id]);
    }
}

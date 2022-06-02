<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UpdateSsOrderRequest;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Email;
use App\Models\EmergencyContact;
use App\Models\Language;
use App\Models\Note;
use App\Models\Phone;
use App\Models\Prefix;
use App\Models\Registration;
use App\Models\Relationship;
use App\Models\Retreat;
use App\Models\SsOrder;
use App\Models\StateProvince;
use App\Models\Touchpoint;

use App\Traits\PhoneTrait;
use App\Traits\SquareSpaceTrait;

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
        $orders = SsOrder::whereIsProcessed(0)->orderBy('order_number')->paginate(25, ['*'], 'ss_orders');
        $processed_orders = SsOrder::whereIsProcessed(1)->orderByDesc('order_number')->paginate(25, ['*'], 'ss_unprocessed_orders');

        return view('squarespace.order.index', compact('orders', 'processed_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }


    /**
     * Show an order to confirm the retreatant for a SquareSpace order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('show-squarespace-order');
        $order = SsOrder::findOrFail($id);
        $prefixes = Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('None', null);
        $states = StateProvince::orderBy('abbreviation')->whereCountryId(config('polanco.country_id_usa'))->pluck('abbreviation', 'id');
        $states->prepend('N/A', null);
        $countries = Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', null);
        $languages = Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('None', null);
        $parishes = Contact::whereSubcontactType(config('polanco.contact_type.parish'))->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        $parish_list[0] = 'N/A';
        $prefix = Prefix::whereName($order->title)->first();
        $couple_prefix = Prefix::whereName($order->couple_title)->first();
        $state = (strlen($order->address_state) > 2) ?
                StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereName(strtoupper($order->address_state))->first() :
                StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereAbbreviation(strtoupper($order->address_state))->first() ;
        //dd($order, $state);
        $order->preferred_language = ($order->preferred_language == 'Inglés') ? 'English' : $order->preferred_language;
        $order->preferred_language = ($order->preferred_language == 'Español') ? 'Spanish' : $order->preferred_language;
        $order->preferred_language = ($order->preferred_language == 'Vietnamita') ? 'Vietnamese' : $order->preferred_language;
        $language = Language::whereIsActive(1)->where('label','LIKE',$order->preferred_language.'%')->first();

        $ids = [];
        $ids['title'] = ($prefix == null) ? null : $prefix->id;
        $ids['couple_title'] = ($couple_prefix == null) ? null : $couple_prefix->id;
        $ids['preferred_language'] = ($language == null) ? null : $language->id;
        $ids['address_state'] = (isset($state->id)) ? $state->id : null;
        $ids['address_country'] = config('polanco.country_id_usa'); // assume US

        // while probably not the most efficient way of doing this it gets me the result
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }

        $retreats = $this->upcoming_retreats($order->event_id);

        // ensure contact_id is part of matching_contacts but if not then add it
        $matching_contacts = $this->matched_contacts($order);
        if (! array_key_exists($order->contact_id,$matching_contacts)) {
            $matching_contacts[$order->contact_id] = $order->retreatant->full_name_with_city;
        }

        $couple = collect([]);
        $couple->name = $order->couple_name;
        $couple->email = $order->couple_email;
        $couple->mobile_phone = $order->couple_mobile_phone;
        $couple->full_address = $order->full_address;
        $couple->date_of_birth = $order->couple_date_of_birth;
        $couple_matching_contacts = (isset($order->couple_name)) ? $this->matched_contacts($couple) : null;

        return view('squarespace.order.edit', compact('order', 'matching_contacts', 'retreats', 'couple_matching_contacts', 'prefixes', 'states', 'countries', 'languages', 'parish_list','ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSsOrderRequest $request, $id)
    {
        $order = SsOrder::findOrFail($id);
        $contact_id = $request->input('contact_id');
        $couple_contact_id = $request->input('couple_contact_id');
        $event_id = $request->input('event_id');
        $event = Retreat::findOrFail($event_id);

        // always update any data changes in order
        $order->contact_id = $contact_id;
        $order->couple_contact_id = $couple_contact_id;
        $order->order_number = $request->input('order_number');
        $order->title = $request->input('title');
        $order->couple_title = $request->input('couple_title');
        $order->name = $request->input('name');
        $order->couple_name = $request->input('couple_name');
        $order->email = $request->input('email');
        $order->couple_email = $request->input('couple_email');
        $order->mobile_phone = $request->input('mobile_phone');
        $order->couple_mobile_phone = $request->input('couple_mobile_phone');
        $order->home_phone = $request->input('home_phone');
        $order->work_phone = $request->input('work_phone');
        $order->address_street = $request->input('address_street');
        $order->address_supplemental = $request->input('address_supplemental');
        $order->address_city = $request->input('address_city');
        $state = ($request->filled('address_state_id')) ? StateProvince::findOrFail(($request->input('address_state_id'))) : null ;
        $order->address_state = (null !== optional($state)->abbreviation) ? optional($state)->abbreviation : $order->address_state;
        $order->address_zip = $request->input('address_zip');
        $country = ($request->filled('address_country_id')) ? Country::findOrFail(($request->input('address_country_id'))) : null ;
        $order->address_country = (null !== optional($country)->iso_code) ? optional($country)->iso_code : $order->address_country;
        $order->dietary = $request->input('dietary');
        $order->couple_dietary = $request->input('couple_dietary');
        $order->date_of_birth = $request->input('date_of_birth');
        $order->couple_date_of_birth = $request->input('couple_date_of_birth');
        $order->room_preference = $request->input('room_preference');
        $preferred_language = ($request->filled('preferred_language_id')) ? Language::findOrFail(($request->input('preferred_language_id'))) : null ;
        $order->preferred_language = (null !== optional($preferred_language)->label) ? optional($preferred_language)->label : $order->preferred_language;
        // $order->parish_id = $request->input('parish_id');
        $order->emergency_contact = $request->input('emergency_contact');
        $order->emergency_contact_relationship = $request->input('emergency_contact_relationship');
        $order->emergency_contact_phone = $request->input('emergency_contact_phone');
        $order->couple_emergency_contact = $request->input('couple_emergency_contact');
        $order->couple_emergency_contact_relationship = $request->input('couple_emergency_contact_relationship');
        $order->couple_emergency_contact_phone = $request->input('couple_emergency_contact_phone');
        $order->deposit_amount = $request->input('deposit_amount');
        $order->event_id = $event_id;
        $order->save();

        if ($order->is_processed) { // the order has already been processed
            flash('SquareSpace Order #<a href="'.url('/squarespace/order/'.$order->id).'">'.$order->order_number.'</a> has already been processed')->error()->important();
            return Redirect::action([self::class, 'index']);
        } else { // the order has not been processed
            if ((!isset($order->participant_id)) && (!isset($order->contact_id))) {
                if ($contact_id == 0) {
                    //dd('Create a new contact');
                    $contact = new Contact;
                    $contact->contact_type = config('polanco.contact_type.individual');
                    $contact->subcontact_type = 0;
                    $contact->first_name = $request->input('first_name');
                    $contact->middle_name = $request->input('middle_name');
                    $contact->last_name = $request->input('last_name');
                    $contact->nick_name = $request->input('nick_name');
                    $contact->sort_name = $request->input('last_name') . ', ' . $request->input('first_name');
                    $contact->display_name = $request->input('first_name') . ' ' . $request->input('last_name');
                    $contact->save();
                } else {
                    $contact = Contact::findOrFail($contact_id);
                }

                if ($order->is_couple) {
                    if ($couple_contact_id == 0 && !isset($order->couple_contact_id)) {
                        // dd('Create a new couple contact');
                        $couple_contact = new Contact;
                        $couple_contact->first_name = $request->input('first_name');
                        $couple_contact->middle_name = $request->input('middle_name');
                        $couple_contact->last_name = $request->input('last_name');
                        $couple_contact->nick_name = $request->input('nick_name');
                        $couple_contact->sort_name = $request->input('last_name') . ', ' . $request->input('first_name');
                        $couple_contact->display_name = $request->input('first_name') . ' ' . $request->input('last_name');
                        $couple_contact->save();
                    } else {
                        $couple_contact = Contact::findOrFail($couple_contact_id);
                    }

                }
                return Redirect::action([self::class, 'edit'],['order' => $id]);

            }


            // process order: we have contact_id and event_id but not participant_id and not processed
            // update contact info (prefix, parish, )

            $contact = Contact::findOrFail($contact_id);

            $contact->prefix_id = ($request->filled('title_id')) ? $request->input('title_id') : $contact->prefix_id;
            $contact->first_name = ($request->filled('first_name')) ? $request->input('first_name') : $contact->first_name;
            $contact->middle_name = ($request->filled('middle_name')) ? $request->input('middle_name') : $contact->middle_name;
            $contact->last_name = ($request->filled('last_name')) ? $request->input('last_name') : $contact->last_name;
            $contact->nick_name = ($request->filled('nick_name')) ? $request->input('nick_name') : $contact->nick_name;
            $contact->birth_date = ($request->filled('date_of_birth')) ? $request->input('date_of_birth') : $contact->birth_date;
            $contact->save();

            // save room_preference
            $room_preference = Note::firstOrNew([
                'entity_table'=>'contact',
                'entity_id'=>$contact_id,
                'subject'=>'Room Preference'
            ]);
            $room_preference->note = $request->filled('room_preference') ? $request->input('room_preference') : $room_preference->note;
            $room_preference->save();

            // save parish
            if ($request->input('parish_id') > 0) {
                $relationship_parishioner = Relationship::firstOrNew([
                    'contact_id_b'=>$contact_id,
                    'relationship_type_id'=>config('polanco.relationship_type.parishioner'),
                    'is_active'=>1
                ]);
                $relationship_parishioner->contact_id_a = $request->input('parish_id');
                $relationship_parishioner->save();
            }
            //TODO: when updating order, change parish name to the display name of the parish

            $email_home = Email::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>config('polanco.location_type.home')]);
            // $request->input('primary_email_location_id') == config('polanco.location_type.home') ? $email_home->is_primary = 1 : $email_home->is_primary = 0;
            $email_home->email = ($request->filled('email')) ? $request->input('email') : null;
            $email_home->is_primary = ($contact->primary_email_location_type_id == config('polanco.location_type.home')) ? 1 : 0;
            // if there is no current primary email then make this one the primary one
            $email_home->is_primary = ($contact->primary_email_location_name == 'N/A' ) ? 1 : $email_home->is_primary;
            $email_home->save();
            //dd($email_home, $request->input('email'), $contact->primary_email_location_name, $contact );

            // because of how the phone_ext field is handled by the model, reset to null on every update to ensure it gets removed and then re-added during the update
            $phone_home_mobile = Phone::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>config('polanco.location_type.home'),
                'phone_type'=>'Mobile']);
            $phone_home_mobile->phone_ext = null;
            // if mobile_phone is primary leave it as such
            // dd($phone_home_mobile, $contact->primary_phone_location_name, config('polanco.location_type.home'), $contact->primary_phone_type, 'Mobile');
            $primary_start = $phone_home_mobile->is_primary;
            $phone_home_mobile->is_primary = ($contact->primary_phone_location_type_id == config('polanco.location_type.home') && $contact->primary_phone_type == 'Mobile') ? 1 : 0;
            // if there is not primary phone then make home:mobile the primary one otherwise do nothing (use existing primary)
            $primary_middle = $phone_home_mobile->is_primary;
            $phone_home_mobile->is_primary = ($contact->primary_phone_location_name == 'N/A' && $contact->primary_phone_type == null) ? 1 : $phone_home_mobile->is_primary;
            $phone_home_mobile->phone = ($request->filled('mobile_phone')) ? $request->input('mobile_phone') : null;
            $phone_home_mobile->save();
            $primary_end = $phone_home_mobile->is_primary;
            $phone_home_phone = Phone::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>config('polanco.location_type.home'),
                'phone_type'=>'Phone']);
            $phone_home_phone->phone_ext = null;
            $phone_home_phone->is_primary = (($contact->primary_phone_location_type_id == config('polanco.location_type.home') && $contact->primary_phone_type == 'Phone')) ?  1 : 0;
            $phone_home_phone->phone = ($request->filled('home_phone')) ? $request->input('home_phone') : null;
            $phone_home_phone->save();

            $phone_work_phone = Phone::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>config('polanco.location_type.work'),
                'phone_type'=>'Phone'
            ]);
            $phone_work_phone->phone_ext = null;
            $phone_work_phone->is_primary = ($contact->primary_phone_location_type_id  == config('polanco.location_type.work') && $contact->primary_phone_type == 'Phone') ? 1 : 0;
            $phone_work_phone->phone = ($request->filled('work_phone')) ? $request->input('work_phone') : null;
            $phone_work_phone->save();

            $home_address = Address::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>config('polanco.location_type.home')
            ]);
            $home_address->street_address = ($request->filled('address_street')) ? $request->input('address_street') : $home_address->street_address;
            $home_address->supplemental_address_1 = ($request->filled('address_supplemental')) ? $request->input('address_supplemental') : $home_address->supplemental_address_1 ;
            $home_address->city = ($request->filled('address_city')) ? $request->input('address_city') : $home_address->city;
            $home_address->state_province_id = ($request->filled('address_state_id')) ? $request->input('address_state_id') : $home_address->state_province_id;
            $home_address->postal_code = ($request->filled('address_zip')) ? $request->input('address_zip') : $home_address->postal_code;
            $home_address->country_id = ($request->filled('address_country_id')) ? $request->input('address_country_id') : $home_address->country_id;
            $home_address->is_primary = ($contact->primary_address_location_type_id == config('polanco.location_type.home')) ? 1 : 0;
            // if there is no current primary address then make this one the primary one
            $home_address->is_primary = ($contact->primary_address_location_name == 'N/A' ) ? 1 : $home_address->is_primary;
            $home_address->save();

            $person_note_dietary = Note::firstOrNew([
                'entity_table'=>'contact',
                'entity_id'=>$contact->id,
                'subject'=>'Dietary Note'
            ]);
            $person_note_dietary->note = ($request->filled('dietary')) ? $request->input('dietary') : null;
            $person_note_dietary->save();

            //emergency contact info
            $emergency_contact = EmergencyContact::firstOrNew([
                'contact_id'=>$contact_id,
            ]);
            $emergency_contact->name = ($request->filled('emergency_contact')) ? $request->input('emergency_contact') : null;
            $emergency_contact->relationship = ($request->filled('emergency_contact_relationship')) ? $request->input('emergency_contact_relationship') : null;
            $emergency_contact->phone = ($request->filled('emergency_contact_phone')) ? $request->input('emergency_contact_phone') : null;
            $emergency_contact->save();

            if (isset($couple_contact_id)) {

                $couple_contact = Contact::findOrFail($couple_contact_id);
                $couple_contact->prefix_id = ($request->filled('couple_title_id')) ? $request->input('couple_title_id') : $couple_contact->prefix_id;
                $couple_contact->first_name = ($request->filled('couple_first_name')) ? $request->input('couple_first_name') : $couple_contact->first_name;
                $couple_contact->middle_name = ($request->filled('couple_middle_name')) ? $request->input('couple_middle_name') : $couple_contact->middle_name;
                $couple_contact->last_name = ($request->filled('last_name')) ? $request->input('couple_last_name') : $couple_contact->last_name;
                $couple_contact->nick_name = ($request->filled('nick_name')) ? $request->input('couple_nick_name') : $couple_contact->nick_name;
                $contact->birth_date = ($request->filled('couple_date_of_birth')) ? $request->input('couple_date_of_birth') : $contact->birth_date;
                $couple_contact->save();

                $couple_email_home = Email::firstOrNew([
                    'contact_id'=>$couple_contact_id,
                    'location_type_id'=>config('polanco.location_type.home')]);
                $couple_email_home->is_primary = ($couple_contact->primary_email_location_name == config('polanco.location_type.home')) ? 1 : 0;
                // if there is no current primary email then make this one the primary one
                $couple_email_home->is_primary = ($couple_contact->primary_email_location_name == 'N/A' ) ? 1 : $couple_email_home->is_primary;
                $couple_email_home->email = ($request->filled('couple_email')) ? $request->input('couple_email') : null;
                $couple_email_home->save();

                // because of how the phone_ext field is handled by the model, reset to null on every update to ensure it gets removed and then re-added during the update
                $couple_phone_home_mobile = Phone::firstOrNew([
                    'contact_id'=>$couple_contact_id,
                    'location_type_id'=>config('polanco.location_type.home'),
                    'phone_type'=>'Mobile']);
                $couple_phone_home_mobile->phone_ext = null;
                // if mobile_phone is primary leave it as such
                // dd($phone_home_mobile, $contact->primary_phone_location_name, config('polanco.location_type.home'), $contact->primary_phone_type, 'Mobile');
                $couple_phone_home_mobile->is_primary = ($couple_contact->primary_phone_location_type_id == config('polanco.location_type.home') && $couple_contact->primary_phone_type == 'Mobile') ? 1 : 0;
                // if there is not primary phone then make home:mobile the primary one otherwise do nothing (use existing primary)
                $couple_phone_home_mobile->is_primary = ($couple_contact->primary_phone_location_name == 'N/A' && $couple_contact->primary_phone_type == null) ? 1 : $couple_phone_home_mobile->is_primary;
                $couple_phone_home_mobile->phone = ($request->filled('couple_mobile_phone')) ? $request->input('couple_mobile_phone') : null;
                $couple_phone_home_mobile->save();

                $couple_home_address = Address::firstOrNew([
                    'contact_id'=>$couple_contact_id,
                    'location_type_id'=>config('polanco.location_type.home')
                ]);
                $couple_home_address->street_address = ($request->filled('address_street')) ? $request->input('address_street') : $couple_home_address->street_address;
                $couple_home_address->supplemental_address_1 = ($request->filled('address_supplemental')) ? $request->input('address_supplemental') : $couple_home_address->supplemental_address_1;
                $couple_home_address->city = ($request->filled('address_city')) ? $request->input('address_city') : $couple_home_address->city;
                $couple_home_address->state_province_id = ($request->filled('address_state_id')) ? $request->input('address_state_id') : $couple_home_address->state_province_id;
                $couple_home_address->postal_code = ($request->filled('address_zip')) ? $request->input('address_zip') : $couple_home_address->postal_code ;
                $couple_home_address->country_id = ($request->filled('address_country')) ? $request->input('address_country') : $couple_home_address->country_id;
                $couple_home_address->is_primary = ($couple_contact->primary_address_location_type_id == config('polanco.location_type.home')) ? 1 : 0;
                // if there is no current primary address then make this one the primary one
                $couple_home_address->is_primary = ($couple_contact->primary_address_location_name == 'N/A' ) ? 1 : $couple_home_address->is_primary;
                $couple_home_address->save();

                // couple emergency contact info
                $couple_emergency_contact = EmergencyContact::firstOrNew([
                    'contact_id'=>$couple_contact_id,
                ]);
                $couple_emergency_contact->name = ($request->filled('couple_emergency_contact')) ? $request->input('couple_emergency_contact') : null;
                $couple_emergency_contact->relationship = ($request->filled('ecouple_mergency_contact_relationship')) ? $request->input('couple_emergency_contact_relationship') : null;
                $couple_emergency_contact->phone = ($request->filled('couple_emergency_contact_phone')) ? $request->input('couple_emergency_contact_phone') : null;
                $couple_emergency_contact->save();
            }

            // TODO: if couple - check if the relationship exists and if not create it

            // create touchpoint
            $touchpoint = new Touchpoint;
            $touchpoint->person_id = $contact_id;
            $touchpoint->staff_id = config('polanco.self.id');
            $touchpoint->type = 'Other';
            $touchpoint->notes = 'Squarespace Order #' . $order->order_number . ' received from ' . $contact->display_name;
            $touchpoint->touched_at = \Carbon\Carbon::now();
            $touchpoint->save();

            // create registration (record deposit, comments, ss_order_number)
            $registration = Registration::firstOrNew([
                'contact_id'=>$contact_id,
                'event_id'=>$event_id,
                'order_id'=>$order->id,
                'source'=>'Squarespace',
                'role_id'=>config('polanco.participant_role_id.retreatant'),
            ]);
            $registration->register_date = $order->created_at;
            $registration->deposit= $request->input('deposit_amount');
            $registration->notes = $request->input('comments');
            $registration->status_id = config('polanco.registration_status_id.registered');
            $registration->remember_token = Str::random(60);
            $registration->save();


            $order->participant_id = $registration->id;
            $order->touchpoint_id = $touchpoint->id;
            // $order->is_processed = 1;
            $order->save();

            flash('SquareSpace Order #: <a href="'.url('/squarespace/order/'.$order->id).'">'.$order->order_number.'</a> processed')->success();

            return Redirect::action([self::class, 'index']);


        }

        // dd($order, $request, $contact, (isset($couple)) ? $couple : null, $event);
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
    }
}

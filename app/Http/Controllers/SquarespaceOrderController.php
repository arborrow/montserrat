<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\SquareSpaceTrait;
use App\Http\Requests\UpdateSsOrderRequest;

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
        $orders = \App\Models\SsOrder::whereIsProcessed(0)->paginate(25, ['*'], 'ss_orders');
        $processed_orders = \App\Models\SsOrder::whereIsProcessed(1)->paginate(25, ['*'], 'ss_unprocessed_orders');

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
        $order = \App\Models\SsOrder::findOrFail($id);
        $prefixes = \App\Models\Prefix::orderBy('name')->pluck('name', 'id');
        $prefixes->prepend('None', null);
        $states = \App\Models\StateProvince::orderBy('abbreviation')->whereCountryId(config('polanco.country_id_usa'))->pluck('abbreviation', 'id');
        $states->prepend('N/A', null);
        $countries = \App\Models\Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', null);
        $languages = \App\Models\Language::orderBy('label')->whereIsActive(1)->pluck('label', 'id');
        $languages->prepend('None', null);
        $parishes = \App\Models\Contact::whereSubcontactType(config('polanco.contact_type.parish'))->orderBy('organization_name', 'asc')->with('address_primary.state', 'diocese.contact_a')->get();
        $parish_list[0] = 'N/A';
        $prefix = \App\Models\Prefix::whereName($order->title)->first();
        $couple_prefix = \App\Models\Prefix::whereName($order->couple_title)->first();
        $state = \App\Models\StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereAbbreviation($order->address_state)->first();
        $order->preferred_language = ($order->preferred_language == 'Inglés') ? 'English' : $order->preferred_language;
        $order->preferred_language = ($order->preferred_language == 'Español') ? 'Spanish' : $order->preferred_language;
        $order->preferred_language = ($order->preferred_language == 'Vietnamita') ? 'Vietnamese' : $order->preferred_language;
        $language = \App\Models\Language::whereIsActive(1)->where('label','LIKE',$order->preferred_language.'%')->first();

        $ids = [];
        $ids['title'] = ($prefix == null) ? null : $prefix->id;
        $ids['couple_title'] = ($couple_prefix == null) ? null : $couple_prefix->id;
        $ids['preferred_language'] = ($language == null) ? null : $language->id;
        $ids['address_state'] = ($state == null) ? null : $state->id;
        $ids['address_country'] = config('polanco.country_id_usa'); // assume US

        // dd($ids,$language,$order->preferred_language);
        // while probably not the most efficient way of doing this it gets me the result
        foreach ($parishes as $parish) {
            $parish_list[$parish->id] = $parish->organization_name.' ('.$parish->address_primary_city.') - '.$parish->diocese_name;
        }

        $retreats = $this->upcoming_retreats();

        $matching_contacts = $this->matched_contacts($order);
        // TODO: ensure contact_id is part of matching_contacts but if not then add it

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
        $order = \App\Models\SsOrder::findOrFail($id);
        $contact_id = $request->input('contact_id');
        $couple_contact_id = $request->input('couple_contact_id');
        $event_id = $request->input('event_id');
        $event = \App\Models\Retreat::findOrFail($event_id);

        if ($order->is_processed) { // the order has already been processed
            flash('SquareSpace Order #<a href="'.url('/squarespace/order/'.$order->id).'">'.$order->order_number.'</a> has already been processed')->error()->important();
            return Redirect::action([self::class, 'index']);
        } else { // the order has not been processed
            if ((!isset($order->participant_id)) && (!isset($order->contact_id))) {
                if ($contact_id == 0) {
                    dd('Create a new contact');
                    $contact = new \App\Models\Contact;
                    $contact->first_name = $request->input('first_name');
                    $contact->middle_name = $request->input('middle_name');
                    $contact->last_name = $request->input('last_name');
                    $contact->nick_name = $request->input('nick_name');
                    $contact->sort_name = $request->input('last_name') . ', ' . $request->input('first_name');
                    $contact->display_name = $request->input('first_name') . ' ' . $request->input('last_name');
                    $contact->save();
                } else {
                    $contact = \App\Models\Contact::findOrFail($contact_id);
                }

                if ($order->is_couple) {
                    if ($couple_contact_id == 0 && !isset($order->couple_contact_id)) {
                        dd('Create a new couple contact');
                        $couple_contact = new \App\Models\Contact;
                        $couple_contact->first_name = $request->input('first_name');
                        $couple_contact->middle_name = $request->input('middle_name');
                        $couple_contact->last_name = $request->input('last_name');
                        $couple_contact->nick_name = $request->input('nick_name');
                        $couple_contact->sort_name = $request->input('last_name') . ', ' . $request->input('first_name');
                        $couple_contact->display_name = $request->input('first_name') . ' ' . $request->input('last_name');
                        $couple_contact->save();
                    } else {
                        $couple_contact = \App\Models\Contact::findOrFail($couple_contact_id);
                    }

                }
                //dd($order, $request, $contact, $couple_contact, $event);
                $order->contact_id = $contact->id; //there should always be something here
                $order->couple_contact_id = (isset($couple_contact->id)) ? $couple_contact->id : null;
                $order->event_id = $event_id;
                $order->save();
                return Redirect::action([self::class, 'edit'],['order' => $id]);

            }


            // process order: we have contact_id and event_id but not participant_id and not processed
            // update contact info (prefix, parish, )

            $contact = \App\Models\Contact::findOrFail($contact_id);

            if($request->filled('title')) {
                $contact->prefix_id = $request->input('title');
            }
            // dd($contact,$request);
            if($request->filled('first_name')) {
                $contact->first_name = $request->input('first_name');
            }
            if($request->filled('middle_name')) {
                $contact->middle_name = $request->input('middle_name');
            }
            if($request->filled('last_name')) {
                $contact->last_name = $request->input('last_name');
            }
            if($request->filled('nick_name')) {
                $contact->nick_name = $request->input('nick_name');
            }
            $contact->save();

            // because of how the phone_ext field is handled by the model, reset to null on every update to ensure it gets removed and then re-added during the update
            $phone_home_mobile = \App\Models\Phone::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>config('polanco.location_type.home'),
                'phone_type'=>'Mobile']);
            $phone_home_mobile->phone_ext = null;
            // if mobile_phone is primary leave it as such
            // dd($phone_home_mobile, $contact->primary_phone_location_name, config('polanco.location_type.home'), $contact->primary_phone_type, 'Mobile');
            $phone_home_mobile->is_primary = ($contact->primary_phone_location_name == config('polanco.location_type.home') && $contact->primary_phone_type == 'Mobile') ? 1 : 0;
            // if there is not primary phone then make home:mobile the primary one otherwise do nothing (use existing primary)
            $phone_home_mobile->is_primary = ($contact->primary_phone_location_name == 'N/A' && $contact->primary_phone_type == null) ? 1 : $phone_home_mobile->is_primary;
            $phone_home_mobile->phone = ($request->filled('mobile_phone')) ? $request->input('mobile_phone') : null;
            $phone_home_mobile->save();

            $phone_home_phone = \App\Models\Phone::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>config('polanco.location_type.home'),
                'phone_type'=>'Phone']);
            $phone_home_phone->phone_ext = null;
            $phone_home_phone->is_primary = (($contact->primary_phone_location_name == config('polanco.location_type.home') && $contact->primary_phone_type == 'Phone')) ?  1 : 0;
            $phone_home_phone->phone = ($request->filled('home_phone')) ? $request->input('home_phone') : null;
            $phone_home_phone->save();

            $phone_work_phone = \App\Models\Phone::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>config('polanco.location_type.work'),
                'phone_type'=>'Phone']);
            $phone_work_phone->phone_ext = null;
            $phone_work_phone->is_primary = ($contact->primary_phone_location_name  == config('polanco.location_type.work') && $contact->primary_phone_type == 'Phone') ? 1 : 0;
            $phone_work_phone->phone = ($request->filled('work_phone')) ? $request->input('work_phone') : null;
            $phone_work_phone->save();

            // update address info
            // update email info
            // update dietary notes
            // update emergency contact info

            // create registration (record deposit, comments, ss_order_number)
/*
            $registration = new \App\Models\Registration;
            $registration->contact_id=$contact_id;
            $registration->event_id=$event_id;
            $registration->source='Squarespace';
            $registration->deposit= $request->input('deposit_amount');
            $registration->notes = $request->input('comments');
            $registration->role_id = config('polanco.participant_role_id.retreatant');
            $registration->status_id = config('polanco.registration_status_id.registered');
            $registration->save();
            ];
            return Redirect::action([self::class, 'edit'],['order' => $id]);


*/

            // $order->participant_id = $registration->id;
            // create touchpoint
            // $order->touchpoint_id = $touchpoint->id;
            // save order as processed

        }

        dd($order, $request, $contact, (isset($couple)) ? $couple : null, $event);
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

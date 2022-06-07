<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateSsDonationRequest;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Country;
use App\Models\DonationType;
use App\Models\Donation;
use App\Models\Email;
use App\Models\Note;
use App\Models\Phone;
use App\Models\Retreat;
use App\Models\SsDonation;
use App\Models\StateProvince;
use App\Models\Touchpoint;

use App\Traits\PhoneTrait;
use App\Traits\SquareSpaceTrait;

use Carbon\Carbon;


class SquarespaceDonationController extends Controller
{   use SquareSpaceTrait;
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
        $this->authorize('show-squarespace-donation');
        $ss_donations = SsDonation::whereIsProcessed(0)->paginate(25, ['*'], 'ss_donations');
        $processed_ss_donations = SsDonation::whereIsProcessed(1)->paginate(25, ['*'], 'ss_unprocessed_donations');
        return view('squarespace.donation.index',compact('ss_donations','processed_ss_donations'));


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
        $this->authorize('show-squarespace-donation');
        $ss_donation = SsDonation::findOrFail($id);
        return view('squarespace.donation.show', compact('ss_donation'));

    }

    /**
     * Show a donation to confirm the retreatant for a SquareSpace order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-squarespace-donation');

        $ss_donation = SsDonation::findOrFail($id);
        $descriptions = DonationType::active()->orderby('name')->pluck('name', 'name');

        $matching_contacts = $this->matched_contacts($ss_donation);
        $retreats = (isset($ss_donation->event_id)) ? $this->upcoming_retreats($ss_donation->event_id,6) : $this->upcoming_retreats(null,6);

        $states = StateProvince::orderBy('abbreviation')->whereCountryId(config('polanco.country_id_usa'))->pluck('abbreviation', 'id');
        $states->prepend('N/A', null);
        $countries = Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', null);

        // try to get the state - if two letter lookup by abbreviation, if more than two letters lookup by name
        $state = (strlen($ss_donation->address_state) > 2) ?
                StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereName(strtoupper($ss_donation->address_state))->first() :
                StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereAbbreviation(strtoupper($ss_donation->address_state))->first() ;

        // attempt to find retreat based on event_id if available or retreat_idnumber
        if ($ss_donation->event_id > 0) {
            $retreat = Retreat::findOrFail($ss_donation->event_id);
        } else {
            $retreat = Retreat::whereIdnumber($ss_donation->idnumber)->first();
        }

        $ids = [];
        $ids['address_state'] = (isset($state->id)) ? $state->id : null;
        $ids['address_country'] = config('polanco.country_id_usa'); // assume US
        $ids['retreat_id'] = isset($retreat->id) ? $retreat->id : null;

        // ensure contact_id is part of matching_contacts but if not then add it
        $matching_contacts = $this->matched_contacts($ss_donation);
        if (! array_key_exists($ss_donation->contact_id,$matching_contacts) && isset($ss_donation->contact_id)) {
            $matching_contacts[$ss_donation->contact_id] = optional($ss_donation->donor)->full_name_with_city;
        }

        return view('squarespace.donation.edit', compact('ss_donation','matching_contacts','retreats','states', 'countries','ids'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSsDonationRequest $request, $id)
    {
        $ss_donation = SsDonation::findOrFail($id);
        $contact_id = $request->input('contact_id');
        $event_id = $request->input('event_id');

        // always update any data changes in order
        $ss_donation->name = ($request->filled('name')) ? $request->input('name') : $ss_donation->name;
        $ss_donation->email = $request->input('email');
        $ss_donation->phone = $request->input('phone');

        $ss_donation->address_street = $request->input('address_street');
        $ss_donation->address_supplemental = $request->input('address_supplemental');
        $ss_donation->address_city = $request->input('address_city');
        $state = ($request->filled('address_state_id')) ? StateProvince::findOrFail(($request->input('address_state_id'))) : null ;
        $ss_donation->address_state = (null !== optional($state)->abbreviation) ? optional($state)->abbreviation : $ss_donation->address_state;
        $ss_donation->address_zip = $request->input('address_zip');
        $country = ($request->filled('address_country_id')) ? Country::findOrFail(($request->input('address_country_id'))) : null ;
        $ss_donation->address_country = (null !== optional($country)->iso_code) ? optional($country)->iso_code : $ss_donation->address_country;

        $ss_donation->amount = $request->input('amount');
        $ss_donation->event_id = $event_id;
        $ss_donation->save();

        if ($ss_donation->is_processed) { // the order has already been processed
            flash('SquareSpace Donation #<a href="'.url('/squarespace/order/'.$ss_donation->id).'">'.$ss_donation->order_number.'</a> has already been processed')->error()->important();
            return Redirect::action([self::class, 'index']);
        } else { // the order has not been processed
            if (!isset($ss_donation->contact_id)) {
                if ($contact_id == 0) {
                    // Create a new contact
                    $contact = new Contact;
                    $contact->contact_type = config('polanco.contact_type.individual');
                    $contact->subcontact_type = 0;
                    $contact->first_name = $request->input('first_name');
                    $contact->last_name = $request->input('last_name');
                    $contact->sort_name = $request->input('last_name') . ', ' . $request->input('first_name');
                    $contact->display_name = $request->input('first_name') . ' ' . $request->input('last_name');
                    $contact->save();

                    $contact_id = $contact->id;
                    $ss_donation->contact_id = $contact->id;
                } else {
                    $contact = Contact::findOrFail($contact_id);
                    $ss_donation->contact_id = $contact->id;
                }

                $ss_donation->save();

                return Redirect::action([self::class, 'edit'],['donation' => $id]);

            }


            // process order: we have contact_id and event_id but not participant_id and not processed
            // update contact info (prefix, parish, )

            $contact = Contact::findOrFail($contact_id);
            $event = Retreat::findOrFail($event_id);

            $contact->first_name = ($request->filled('first_name')) ? $request->input('first_name') : $contact->first_name;
            $contact->last_name = ($request->filled('last_name')) ? $request->input('last_name') : $contact->last_name;
            $contact->save();

            $primary_email_location_id = ($contact->primary_email_location_id == 'N/A') ? 1 : $contact->primary_email_location_id;
            $email = Email::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=> ($primary_email_location_id > 0) ? $primary_email_location_id : 1,
            ]);
            $email->email = ($request->filled('email')) ? $request->input('email') : null;
            $email->is_primary = (isset($email->is_primary)) ? $email->is_primary : 1;
            $email->save();

            // assumes phone provided is home (location), mobile (type)
            // because of how the phone_ext field is handled by the model, reset to null on every update to ensure it gets removed and then re-added during the update
            $primary_phone_location_type_id = ($contact->primary_phone_location_type_id == 'N/A') ? 1 : $contact->primary_phone_location_type_id;
            $primary_phone = Phone::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>($primary_phone_location_type_id > 0) ? $primary_phone_location_type_id : 1,
                'phone_type'=>'Mobile'
            ]);
            $primary_phone->phone_ext = null;
            $primary_phone->is_primary = (isset($primary_phone->is_primary)) ? $primary_phone->is_primary : 1;
            // if there is not primary phone then make home:mobile the primary one otherwise do nothing (use existing primary)
            $primary_phone->phone = ($request->filled('phone')) ? $request->input('phone') : null;
            $primary_phone->save();

            $primary_address_location_type_id = ($contact->primary_address_location_type_id == 'N/A') ? 1 : $contact->primary_address_location_type_id;
            $primary_address = Address::firstOrNew([
                'contact_id'=>$contact_id,
                'location_type_id'=>($primary_address_location_type_id > 0) ? $primary_address_location_type_id : 1,
            ]);
            $primary_address->street_address = ($request->filled('address_street')) ? $request->input('address_street') : $primary_address->street_address;
            $primary_address->supplemental_address_1 = ($request->filled('address_supplemental')) ? $request->input('address_supplemental') : $primary_address->supplemental_address_1 ;
            $primary_address->city = ($request->filled('address_city')) ? $request->input('address_city') : $primary_address->city;
            $primary_address->state_province_id = ($request->filled('address_state_id')) ? $request->input('address_state_id') : $primary_address->state_province_id;
            $primary_address->postal_code = ($request->filled('address_zip')) ? $request->input('address_zip') : $primary_address->postal_code;
            $primary_address->country_id = ($request->filled('address_country_id')) ? $request->input('address_country_id') : $primary_address->country_id;
            $primary_address->is_primary = (isset($primary_address->is_primary)) ? $primary_address->is_primary : 1;
            $primary_address->save();

            // create touchpoint
            $touchpoint = new Touchpoint;
            $touchpoint->person_id = $contact_id;
            $touchpoint->staff_id = config('polanco.self.id');
            $touchpoint->type = 'Other';
            $touchpoint->notes = 'Squarespace Contribution #' . $ss_donation->id . ' received from ' . $contact->display_name;
            $touchpoint->touched_at = Carbon::now();
            $touchpoint->save();
            $ss_donation->touchpoint_id = $touchpoint->id;

            // create donation(s) (record deposit as donation (with no payment), notes)
            $donation = new Donation;
            $donation->contact_id = $contact_id;
            $donation->event_id = ($request->filled('event_id')) ? $event_id : null;
            $donation->donation_description = ($request->filled('donation_description')) ? config('polanco.donation_descriptions.'.$request->input('donation_description')) : null;
            // $donation->donation_description = 'Retreat Deposits';
            // TODO: verify with Catherine that she uses the event start date for both retreat and non-retreat funding
            $donation->donation_date = (isset($ss_donation->event->start_date)) ? $ss_donation->event->start_date : $ss_donation->created_at;
            $donation->donation_amount = $ss_donation->amount;
            // TODO: check if for retreat or fund; consider creating designated or purpose attribute (or consolidating the two fields into the fund field)
            $donation->Notes = 'SS Contribution #' . $ss_donation->id . ' for Retreat #' . optional($ss_donation->event)->idnumber;
            $donation->save();
            $ss_donation->donation_id = $donation->donation_id;

            $ss_donation->is_processed = 1;
            $ss_donation->save();

            flash('<a href="'.url('/squarespace/donation/'.$ss_donation->id).'">SquareSpace Donation #'.$ss_donation->id.'</a> processed')->success();

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
        //
    }
}

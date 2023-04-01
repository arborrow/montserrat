<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSquarespaceContributionRequest;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Donation;
use App\Models\DonationType;
use App\Models\Email;
use App\Models\Phone;
use App\Models\Registration;
use App\Models\Retreat;
use App\Models\SquarespaceContribution;
use App\Models\StateProvince;
use App\Models\Touchpoint;
use App\Traits\SquareSpaceTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class SquarespaceContributionController extends Controller
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
        $this->authorize('show-squarespace-contribution');
        $ss_contributions = SquarespaceContribution::whereIsProcessed(0)->orderBy('created_at')->paginate(25, ['*'], 'ss_contributions');
        $processed_ss_contributions = SquarespaceContribution::whereIsProcessed(1)->orderByDesc('created_at')->paginate(25, ['*'], 'ss_unprocessed_contributions');

        return view('squarespace.contribution.index', compact('ss_contributions', 'processed_ss_contributions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //use permisson of target, namely squarespace.contribution.index
        $this->authorize('show-squarespace-contribution');

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //use permisson of target, namely squarespace.contribution.index
        $this->authorize('show-squarespace-contribution');

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
        $this->authorize('show-squarespace-contribution');
        $ss_contribution = SquarespaceContribution::findOrFail($id);

        return view('squarespace.contribution.show', compact('ss_contribution'));
    }

    /**
     * Show a contribution to confirm the retreatant for a SquareSpace order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-squarespace-contribution');

        $ss_contribution = SquarespaceContribution::findOrFail($id);
        $descriptions = DonationType::active()->orderby('name')->pluck('name', 'name');

        $matching_contacts = $this->matched_contacts($ss_contribution);
        $retreats = (isset($ss_contribution->event_id)) ? $this->upcoming_retreats($ss_contribution->event_id, 6) : $this->upcoming_retreats(null, 6);

        if (isset($ss_contribution->contact_id) && $ss_contribution->contact_id > 0) {
            $retreats = $this->contact_retreats($ss_contribution->contact_id);
        }

        $states = StateProvince::orderBy('abbreviation')->whereCountryId(config('polanco.country_id_usa'))->pluck('abbreviation', 'id');
        $states->prepend('N/A', null);
        $countries = Country::orderBy('iso_code')->pluck('iso_code', 'id');
        $countries->prepend('N/A', null);

        // try to get the state - if two letter lookup by abbreviation, if more than two letters lookup by name
        $state = (strlen($ss_contribution->address_state) > 2) ?
                StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereName(strtoupper($ss_contribution->address_state))->first() :
                StateProvince::whereCountryId(config('polanco.country_id_usa'))->whereAbbreviation(strtoupper($ss_contribution->address_state))->first();

        // attempt to find retreat based on event_id if available or retreat_idnumber
        if ($ss_contribution->event_id > 0) {
            $retreat = Retreat::findOrFail($ss_contribution->event_id);
        } else {
            $retreat = Retreat::whereIdnumber($ss_contribution->idnumber)->first();
        }

        $ids = [];
        $ids['address_state'] = (isset($state->id)) ? $state->id : null;
        $ids['address_country'] = config('polanco.country_id_usa'); // assume US
        $ids['retreat_id'] = isset($retreat->id) ? $retreat->id : null;

        // ensure contact_id is part of matching_contacts but if not then add it
        $matching_contacts = $this->matched_contacts($ss_contribution);
        if (! array_key_exists($ss_contribution->contact_id, $matching_contacts) && isset($ss_contribution->contact_id)) {
            $matching_contacts[$ss_contribution->contact_id] = optional($ss_contribution->donor)->full_name_with_city;
        }

        return view('squarespace.contribution.edit', compact('ss_contribution', 'matching_contacts', 'retreats', 'states', 'countries', 'ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSquarespaceContributionRequest $request, $id)
    {
        $ss_contribution = SquarespaceContribution::findOrFail($id);
        $contact_id = $request->input('contact_id');
        $event_id = ($request->filled('event_id')) ? $request->input('event_id') : null;

        // always update any data changes in order
        $ss_contribution->name = ($request->filled('name')) ? $request->input('name') : $ss_contribution->name;
        $ss_contribution->email = $request->input('email');
        $ss_contribution->phone = $request->input('phone');

        $ss_contribution->address_street = $request->input('address_street');
        $ss_contribution->address_supplemental = $request->input('address_supplemental');
        $ss_contribution->address_city = $request->input('address_city');
        $state = ($request->filled('address_state_id')) ? StateProvince::findOrFail(($request->input('address_state_id'))) : null;
        $ss_contribution->address_state = (null !== optional($state)->abbreviation) ? optional($state)->abbreviation : $ss_contribution->address_state;
        $ss_contribution->address_zip = $request->input('address_zip');
        $country = ($request->filled('address_country_id')) ? Country::findOrFail(($request->input('address_country_id'))) : null;
        $ss_contribution->address_country = (null !== optional($country)->iso_code) ? optional($country)->iso_code : $ss_contribution->address_country;

        $ss_contribution->comments = $request->input('comments');
        $ss_contribution->amount = $request->input('amount');
        $ss_contribution->event_id = $event_id;
        $ss_contribution->save();

        if ($ss_contribution->is_processed) { // the order has already been processed
            flash('SquareSpace Contribution #<a href="'.url('/squarespace/order/'.$ss_contribution->id).'">'.$ss_contribution->order_number.'</a> has already been processed')->error()->important();

            return Redirect::action([self::class, 'index']);
        } else { // the contribution has not been processed
            if (! isset($ss_contribution->contact_id)) {
                if ($contact_id == 0) {
                    // Create a new contact
                    $contact = new Contact;
                    $contact->contact_type = config('polanco.contact_type.individual');
                    $contact->subcontact_type = 0;
                    $contact->first_name = $request->input('first_name');
                    $contact->last_name = $request->input('last_name');
                    $contact->sort_name = $request->input('last_name').', '.$request->input('first_name');
                    $contact->display_name = $request->input('first_name').' '.$request->input('last_name');
                    $contact->save();

                    $contact_id = $contact->id;
                    $ss_contribution->contact_id = $contact->id;
                } else {
                    $contact = Contact::findOrFail($contact_id);
                    $ss_contribution->contact_id = $contact->id;
                }

                $ss_contribution->save();

                return Redirect::action([self::class, 'edit'], ['contribution' => $id]);
            }

            // process contribution: we have contact_id and event_id but not participant_id and not processed

            $contact = Contact::findOrFail($contact_id);
            $event = (isset($event_id)) ? Retreat::findOrFail($event_id) : null;

            $contact->first_name = ($request->filled('first_name')) ? $request->input('first_name') : $contact->first_name;
            $contact->last_name = ($request->filled('last_name')) ? $request->input('last_name') : $contact->last_name;
            $contact->save();

            $primary_email_location_id = ($contact->primary_email_location_id == 'N/A') ? 1 : $contact->primary_email_location_id;
            $email = Email::firstOrNew([
                'contact_id' => $contact_id,
                'location_type_id' => ($primary_email_location_id > 0) ? $primary_email_location_id : 1,
            ]);
            $email->email = ($request->filled('email')) ? $request->input('email') : $email->email;
            $email->is_primary = (isset($email->is_primary)) ? $email->is_primary : 1;
            $email->save();

            // assumes phone provided is home (location), mobile (type)
            // because of how the phone_ext field is handled by the model, reset to null on every update to ensure it gets removed and then re-added during the update
            $primary_phone_location_type_id = ($contact->primary_phone_location_type_id == 'N/A') ? 1 : $contact->primary_phone_location_type_id;
            $primary_phone = Phone::firstOrNew([
                'contact_id' => $contact_id,
                'location_type_id' => ($primary_phone_location_type_id > 0) ? $primary_phone_location_type_id : 1,
                'phone_type' => 'Mobile',
            ]);
            $primary_phone->phone_ext = null;
            $primary_phone->is_primary = (isset($primary_phone->is_primary)) ? $primary_phone->is_primary : 1;
            // if there is not primary phone then make home:mobile the primary one otherwise do nothing (use existing primary)
            $primary_phone->phone = ($request->filled('phone')) ? $request->input('phone') : $primary_phone->phone;
            $primary_phone->save();

            $primary_address_location_type_id = ($contact->primary_address_location_type_id == 'N/A') ? 1 : $contact->primary_address_location_type_id;
            $primary_address = Address::firstOrNew([
                'contact_id' => $contact_id,
                'location_type_id' => ($primary_address_location_type_id > 0) ? $primary_address_location_type_id : 1,
            ]);
            $primary_address->street_address = ($request->filled('address_street')) ? $request->input('address_street') : $primary_address->street_address;
            $primary_address->supplemental_address_1 = ($request->filled('address_supplemental')) ? $request->input('address_supplemental') : $primary_address->supplemental_address_1;
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
            $touchpoint->notes = 'Squarespace Contribution #'.$ss_contribution->id.' received from '.$contact->display_name;
            $touchpoint->touched_at = Carbon::now();
            $touchpoint->save();
            $ss_contribution->touchpoint_id = $touchpoint->id;

            // create donation(s) (record deposit as donation (with no payment), notes)
            $donation = new Donation;
            $donation->contact_id = $contact_id;
            $donation->event_id = ($request->filled('event_id')) ? $event_id : $donation->event_id;
            $donation->donation_description = ($request->filled('donation_description')) ? $request->input('donation_description') : $donation->donation_description;
            $donation->donation_date = (isset($ss_contribution->event->start_date)) ? $ss_contribution->event->start_date : $ss_contribution->created_at;
            $donation->donation_amount = $ss_contribution->amount;
            // TODO: check if for retreat or fund; consider creating designated or purpose attribute (or consolidating the two fields into the fund field)
            $retreat_note = (isset($event_id)) ? ' for Retreat #'.optional($ss_contribution->event)->idnumber : null;
            $donation->Notes = 'SS Contribution #'.$ss_contribution->id.$retreat_note.'. '.$ss_contribution->comments;
            $donation->save();
            $ss_contribution->donation_id = $donation->donation_id;

            // TODO: carefully consider possible impact of overwriting data, currently set to avoid overwriting most data
            //create registration if it does not exist for a
            if (isset($event_id) && config('polanco.donation_descriptions.'.$request->input('donation_description')) == 'Retreat Deposits') {
                $registration = Registration::firstOrNew([
                    'contact_id' => $contact_id,
                    'event_id' => $event_id,
                    'role_id' => config('polanco.participant_role_id.retreatant'),
                ]);
                $registration->source = (isset($registration->source)) ? $registration->source : 'Squarespace';
                $registration->notes = 'Squarespace Contribution #'.$ss_contribution->id.'. '.$registration->notes;
                $registration->register_date = (isset($registration->register_date)) ? $registration->register_date : $ss_contribution->created_at;
                $registration->deposit = (isset($registration->deposit)) ? $registration->deposit : $request->input('amount');
                $registration->status_id = (isset($registration->status_id)) ? $registration->status_id : config('polanco.registration_status_id.registered');
                $registration->remember_token = (isset($registration->remember_token)) ? $registration->remember_token : Str::random(60);
                $registration->save();
            }

            $ss_contribution->is_processed = 1;
            $ss_contribution->save();

            flash('<a href="'.url('/squarespace/contribution/'.$ss_contribution->id).'">SquareSpace Contribution #'.$ss_contribution->id.'</a> processed')->success();

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
        //use permisson of target, namely squarespace.contribution.index
        $this->authorize('show-squarespace-contribution');

        return Redirect::action([self::class, 'index']);
    }

    /**
     * Reset to re-select the retreatant for a SquareSpace contribution.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset($id)
    {
        $this->authorize('update-squarespace-contribution');

        $ss_contribution = SquarespaceContribution::findOrFail($id);
        $ss_contribution->contact_id = null;
        $ss_contribution->save();

        return Redirect::action([self::class, 'edit'], ['contribution' => $id]);
    }
}

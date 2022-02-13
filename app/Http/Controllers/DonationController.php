<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationAgcRequest;
use App\Http\Requests\DonationSearchRequest;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DonationController extends Controller
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
        $this->authorize('show-donation');

        // rather than using the active donation_descriptions from DonationType model, let's continue to show all of the existing donation_descriptions in the Donations table so that any that are not in the DonationType table can be cleaned up
        $donation_descriptions = DB::table('Donations')->selectRaw('MIN(donation_id) as donation_id, donation_description, count(*) as count')->groupBy('donation_description')->orderBy('donation_description')->whereNull('deleted_at')->get();
        // dd($donation_descriptions);
        $donations = \App\Models\Donation::orderBy('donation_date', 'desc')->with('contact.prefix', 'contact.suffix', 'retreat')->paginate(25, ['*'], 'donations');
        //dd($donations);
        return view('donations.index', compact('donations', 'donation_descriptions'));
    }

    public function index_type($donation_id = null)
    {
        $this->authorize('show-donation');
        $donation_descriptions = DB::table('Donations')->selectRaw('MIN(donation_id) as donation_id, donation_description, count(*) as count')->groupBy('donation_description')->orderBy('donation_description')->whereNull('deleted_at')->get();
        $donation = \App\Models\Donation::findOrFail($donation_id);
        $donation_description = $donation->donation_description;

        $defaults = [];
        $defaults['type'] = $donation_description;

        $donations = \App\Models\Donation::whereDonationDescription($donation_description)->orderBy('donation_date', 'desc')->with('contact.prefix', 'contact.suffix')->paginate(25, ['*'], 'donations');

        return view('donations.index', compact('donations', 'donation_descriptions', 'defaults'));   //
    }

    public function search()
    {
        $this->authorize('show-donation');

        $descriptions = \App\Models\DonationType::active()->orderby('name')->pluck('name', 'name');
        $descriptions->prepend('N/A', '');

        $retreats = \App\Models\Registration::leftjoin('event', 'participant.event_id', '=', 'event.id')->select(DB::raw('CONCAT(event.idnumber, "-", event.title, " (",DATE_FORMAT(event.start_date,"%m-%d-%Y"),")") as description'), 'event.id')->orderBy('event.start_date', 'desc')->pluck('event.description', 'event.id');
        $retreats->prepend('Unassigned', '');

        return view('donations.search', compact('retreats', 'descriptions'));
    }

    public function results(DonationSearchRequest $request)
    {
        $this->authorize('show-donation');
        if (! empty($request)) {
            $all_donations = \App\Models\Donation::filtered($request)->orderBy('donation_date')->get();
            $donations = \App\Models\Donation::filtered($request)->orderBy('donation_date')->paginate(25, ['*'], 'donations');
            $donations->appends($request->except('page'));
        } else {
            $all_donations = \App\Models\Donation::orderBy('name')->get();
            $donations = \App\Models\Donation::orderBy('name')->paginate(25, ['*'], 'donations');
        }

        return view('donations.results', compact('donations', 'all_donations'));
    }

    public function overpaid()
    {
        $this->authorize('show-donation');
        $overpaid = DB::table('Donations_payment as p')
         ->select(DB::raw('d.contact_id, c.sort_name, d.donation_id, d.donation_date, ROUND(SUM(p.payment_amount),2) as paid, ROUND(d.donation_amount,2) as pledged'))
         ->leftjoin('Donations as d', 'd.donation_id', '=', 'p.donation_id')
         ->leftjoin('contact as c', 'd.contact_id', '=', 'c.id')
         ->whereRaw('d.deleted_at IS NULL AND p.deleted_at IS NULL')
         ->groupBy('p.donation_id')
         ->havingRaw('paid>pledged')
         ->orderBy('d.donation_date', 'DESC')->get();

        return view('donations.overpaid', compact('overpaid'));
    }

    public function agc($year, DonationAgcRequest $request)
    {
        $this->authorize('show-donation');

        if (! isset($year)) {
            $year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        }
        $unthanked = ! is_null($request->input('unthanked')) ? $request->input('unthanked') : null;

        // only show for FY 2008 and above because data does not exist
        // this is rather hacky and particular to MJRH data
        $year = (int) $year;
        if (! ($year >= 2007 && $year <= (date('Y') + 1))) {
            abort(404, 'Invalid year');
        }
        $prev_year = $year - 1;

        if (is_null($unthanked)) {
            $all_donations = \App\Models\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year.'-07-01')->where('donation_date', '<', $year.'-07-01')->with('contact.prefix', 'contact.suffix', 'contact.agc2019', 'payments')
            ->get();
            $donations = \App\Models\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year.'-07-01')->where('donation_date', '<', $year.'-07-01')->with('contact.prefix', 'contact.suffix', 'contact.agc2019', 'payments')
            ->paginate(25, ['*'], 'donations');
        } else {
            $all_donations = \App\Models\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year.'-07-01')->where('donation_date', '<', $year.'-07-01')
                ->with('contact.prefix', 'contact.suffix', 'contact.agc2019', 'payments')->whereNull('Thank you')->get();
            $donations = \App\Models\Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year.'-07-01')->where('donation_date', '<', $year.'-07-01')
                ->with('contact.prefix', 'contact.suffix', 'contact.agc2019', 'payments')->whereNull('Thank you')->paginate(25, ['*'], 'donations');
        }

        $total['pledged'] = $all_donations->sum('donation_amount');
        $total['paid'] = $all_donations->sum('payments_paid');
        if ($total['pledged'] > 0) {
            $total['percent'] = ($total['paid'] / $total['pledged']) * 100;
        } else {
            $total['percent'] = 0;
        }
        $total['year'] = $year;
        $total['unthanked'] = $unthanked;

        return view('donations.agc', compact('donations', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null, $event_id = null, $type = null)
    {
        $this->authorize('create-donation');

        $subcontact_type_id = (isset($type)) ? config('polanco.contact_type.'.$type) : null;

        if ($id > 0) {
            $donor = \App\Models\Contact::findOrFail($id); // a lazy way to fail if no donor
            $donor_events = \App\Models\Registration::whereContactId($id)->get();
            $donors = \App\Models\Contact::whereId($id)->pluck('sort_name', 'id');
        } else {
            $donors = \App\Models\Contact::whereContactType(config('polanco.contact_type.individual'))->orderBy('sort_name')->pluck('sort_name', 'id');
        }
        if (isset($subcontact_type_id) && ($id == 0)) {
            $donors = \App\Models\Contact::whereSubcontactType($subcontact_type_id)->orderBy('sort_name')->pluck('sort_name', 'id');
        }
        if (isset($event_id)) {
            $retreats = \App\Models\Retreat::findOrFail($event_id); // a lazy way to fail if unknown event_id
            $retreats = \App\Models\Retreat::select(DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->whereId($event_id)->pluck('description', 'id');
        } else {
            // $retreats = \App\Models\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("is_active", "=", 1)->orderBy('start_date')->pluck('description', 'id');
            $retreats = \App\Models\Registration::leftjoin('event', 'participant.event_id', '=', 'event.id')->select(DB::raw('CONCAT(event.idnumber, "-", event.title, " (",DATE_FORMAT(event.start_date,"%m-%d-%Y"),")") as description'), 'event.id')->whereContactId($id)->orderBy('event.start_date', 'desc')->pluck('event.description', 'event.id');
            $retreats->prepend('Unassigned', 0);
        }

        //dd($donors);
        $payment_methods = config('polanco.payment_method');
        $descriptions = \App\Models\DonationType::active()->orderby('name')->pluck('name', 'name');
        $dt_today = \Carbon\Carbon::today();
        $defaults['today'] = $dt_today->month.'/'.$dt_today->day.'/'.$dt_today->year;
        $defaults['retreat_id'] = $event_id;

        return view('donations.create', compact('retreats', 'donors', 'descriptions', 'payment_methods', 'defaults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * authorize (permission check)
     * validate input
     * create and save new donation record
     * redirect to donation.index
     */
    public function store(StoreDonationRequest $request)
    {
        $this->authorize('create-donation');

        $donation = new \App\Models\Donation;
        $donation->contact_id = $request->input('donor_id');
        if ($request->input('event_id') > 0) {
            $donation->event_id = $request->input('event_id');
        }
        $donation->donation_date = $request->input('donation_date');
        $donation->donation_amount = $request->input('donation_amount');
        $donation->donation_description = $request->input('donation_description');
        $donation->Notes = $request->input('notes');
        $donation->terms = $request->input('terms');
        $donation->start_date = $request->input('start_date');
        $donation->end_date = $request->input('end_date');
        $donation->donation_install = $request->input('donation_install');
        $donation->save();

        // create donation_payments
        $payment = new \App\Models\Payment;
        $payment->donation_id = $donation->donation_id;
        $payment->payment_amount = $request->input('payment_amount');
        $payment->payment_date = $request->input('payment_date');
        $payment->payment_description = $request->input('payment_description');
        if ($request->input('payment_description') == 'Credit card') {
            $payment->ccnumber = substr($request->input('payment_idnumber'), -4);
        }
        if ($request->input('payment_description') == 'Check') {
            $payment->cknumber = $request->input('payment_idnumber');
        }        //dd($payment, $donation);
        $payment->save();

        flash('Donation ID#: <a href="'.url('/donation/'.$donation->donation_id).'">'.$donation->donation_id.'</a> added')->success();

        return redirect($donation->contact->contact_url.'#donations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-donation');
        $donation = \App\Models\Donation::with('payments', 'contact')->findOrFail($id);

        return view('donations.show', compact('donation')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-donation');
        //get this retreat's information
        $donation = \App\Models\Donation::with('payments', 'contact')->findOrFail($id);
        $descriptions = \App\Models\DonationType::active()->orderby('name')->pluck('name', 'name');

        if (! $descriptions->search($donation->donation_description)) {
            $descriptions->prepend($donation->donation_description.' (inactive donation type)', $donation->donation_description);
            // dd($descriptions,$donation->donation_description);
        }

        // $retreats = \App\Models\Retreat::select(\DB::raw('CONCAT_WS(" ",CONCAT(idnumber," -"), title, CONCAT("(",DATE_FORMAT(start_date,"%m-%d-%Y"),")")) as description'), 'id')->where("end_date", ">", $donation->donation_date)->where("is_active", "=", 1)->orderBy('start_date')->pluck('description', 'id');
        $retreats = \App\Models\Registration::leftjoin('event', 'participant.event_id', '=', 'event.id')->select(DB::raw('CONCAT(event.idnumber, "-", event.title, " (",DATE_FORMAT(event.start_date,"%m-%d-%Y"),")") as description'), 'event.id')->whereContactId($donation->contact_id)->orderBy('event.start_date', 'desc')->pluck('event.description', 'event.id');

        $retreats->prepend('Unassigned', 0);
        $defaults['event_id'] = $donation->event_id;
        // $descriptions->prepend('Unassigned', 0); // no longer needed since all donations have an active donation description
        //$descriptions->toArray();
        // $defaults['description_key'] = $descriptions->search($donation->donation_description); // no longer needed to lookup donation type key, just use the existing value

        // check if current event is further in the past and if so add it
        if (! isset($retreats[$donation->event_id])) {
            $retreats[$donation->event_id] = $donation->retreat_idnumber.' - '.$donation->retreat_name.' ('.$donation->retreat_start_date.')';
        }

        return view('donations.edit', compact('donation', 'descriptions', 'defaults', 'retreats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDonationRequest $request, $id)
    {
        $this->authorize('update-donation');

        $donation = \App\Models\Donation::findOrFail($id);
        $donation->contact_id = $request->input('donor_id');
        if ($request->input('event_id') > 0) {
            $donation->event_id = $request->input('event_id');
        }
        $donation->donation_date = $request->input('donation_date') ? $request->input('donation_date') : null;
        $donation->donation_amount = $request->input('donation_amount');
        $donation->donation_description = $request->input('donation_description');
        $donation->notes1 = $request->input('notes1'); //primary_contact
        $donation->notes = $request->input('notes');
        $donation->terms = $request->input('terms');
        $donation->start_date = $request->input('start_date');
        $donation->end_date = $request->input('end_date');
        $donation->donation_install = $request->input('donation_install');
        if ($request->input('donation_thank_you') == 'Y') {
            $donation['Thank You'] = $request->input('donation_thank_you'); //field has space in database and should be changed at some point
        } else {
            $donation['Thank You'] = null;
        }
        $donation->save();

        flash('Donation ID#: <a href="'.url('/donation/'.$donation->donation_id).'">'.$donation->donation_id.'</a> updated')->success();

        return Redirect::action([\App\Http\Controllers\DonationController::class, 'show'], $donation->donation_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-donation');
        $donation = \App\Models\Donation::findOrFail($id);
        $contact = \App\Models\Contact::findOrFail($donation->contact_id);
        //deletion of payments implied on the model
        \App\Models\Donation::destroy($id);
        // disassociate registration with a donation that is being deleted - there should only be one
        $registration = \App\Models\Registration::whereDonationId($id)->first();
        if (isset($registration->donation_id)) {
            $registration->donation_id = null;
            $registration->save();
        }

        flash('Donation ID#: '.$donation->donation_id.' deleted')->warning()->important();

        return redirect()->to($contact->contact_url);
    }

    /**
     * Process retreat payments from retreat.payments.
     *
     * @param  \Illuminate\Http\Request  $request
     * $request contains a $donations array with fields for id, pledge, paid, method and terms
     * this method will only be used for retreat offerings - other types of donations should be handled elsewhere
     * primary use is for creating retreat offering donations but will have ability to edit existing retreat offerings
     * @return \Illuminate\Http\Response
     */
    public function retreat_payments_update(Request $request)
    {   // I removed the permission check for update-payment as it seemed redundant to update-donation and it makes testing a little easier
        $this->authorize('update-donation');
        if ($request->input('event_id')) {
            $event_id = $request->input('event_id');
        }
        if (! is_null($request->input('donations'))) {
            foreach ($request->input('donations') as $key => $value) {
                $registration = \App\Models\Registration::findOrFail($key);
                // if there is not already an existing donation and there is a pledge
                if (is_null($registration->donation_id)) { //create a new donation
                    if ($value['pledge'] > 0) {
                        $donation = new \App\Models\Donation;
                        $donation->contact_id = $registration->contact_id;

                        /* n.b  that in PPD Donations retreat_id referred to Retreats and not the events table
                         * will need to convert data to in Donations to use events_id before moving into production
                         * which means resolving all those that do not have an event id (if any)
                         * and ensuring start and end date for all events
                         */
                        $donation->event_id = $registration->event_id;

                        /*
                         * Ideally I would like this to be the donation description id but for now I will keep the descriptioon field a varchar rather than integer
                         */

                        $donation->donation_description = 'Retreat Funding'; // this page/method is only handling retreat offerings
                        $donation->donation_date = $registration->retreat_end_date;
                        $donation->donation_amount = $value['pledge'];
                        $donation->terms = $value['terms'];
                        $donation->save();
                        $registration->donation_id = $donation->donation_id;
                        $registration->save();

                        // create donation_payments
                        $payment = new \App\Models\Payment;
                        $payment->donation_id = $donation->donation_id;
                        $payment->payment_amount = $value['paid'];
                        $payment->payment_date = $donation->donation_date;
                        $payment->payment_description = $value['method'];
                        if ($value['method'] == 'Credit card') {
                            $payment->ccnumber = substr($value['idnumber'], -4);
                        }
                        if ($value['method'] == 'Check') {
                            $payment->cknumber = $value['idnumber'];
                        }
                        //dd($payment, $donation);
                        $payment->save();
                    }
                } else {
                    $donation = \App\Models\Donation::findOrFail($registration->donation_id); // update an existing donation
                    $donation->donation_amount = $value['pledge'];
                    $donation->terms = $value['terms'];
                    $donation->save();
                }
            }
        }

        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $request->input('event_id'));
    }
}

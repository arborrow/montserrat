<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DonationAgcRequest;
use App\Http\Requests\DonationSearchRequest;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Models\Contact;
use App\Models\Donation;
use App\Models\DonationType;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Retreat;
use App\Models\SquarespaceContribution;
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
     */
    public function index(): View
    {
        $this->authorize('show-donation');

        // rather than using the active donation_descriptions from DonationType model, let's continue to show all of the existing donation_descriptions in the Donations table so that any that are not in the DonationType table can be cleaned up
        $donation_descriptions = DB::table('Donations')->selectRaw('MIN(donation_id) as donation_id, donation_description, count(*) as count')->groupBy('donation_description')->orderBy('donation_description')->whereNull('deleted_at')->get();
        // dd($donation_descriptions);
        $donations = Donation::orderBy('donation_date', 'desc')->with('contact.prefix', 'contact.suffix', 'retreat')->paginate(25, ['*'], 'donations');
        //dd($donations);
        return view('donations.index', compact('donations', 'donation_descriptions'));
    }

    public function index_type($donation_id = null): View
    {
        $this->authorize('show-donation');
        $donation_descriptions = DB::table('Donations')->selectRaw('MIN(donation_id) as donation_id, donation_description, count(*) as count')->groupBy('donation_description')->orderBy('donation_description')->whereNull('deleted_at')->get();
        $donation = Donation::findOrFail($donation_id);
        $donation_description = $donation->donation_description;

        $defaults = [];
        $defaults['type'] = $donation_description;

        $donations = Donation::whereDonationDescription($donation_description)->orderBy('donation_date', 'desc')->with('contact.prefix', 'contact.suffix')->paginate(25, ['*'], 'donations');

        return view('donations.index', compact('donations', 'donation_descriptions', 'defaults'));   //
    }

    public function search(): View
    {
        $this->authorize('show-donation');

        $descriptions = DonationType::active()->orderby('name')->pluck('name', 'name');
        $descriptions->prepend('N/A', '');

        $retreats = Registration::leftjoin('event', 'participant.event_id', '=', 'event.id')->select(DB::raw('CONCAT(event.idnumber, "-", event.title, " (",DATE_FORMAT(event.start_date,"%m-%d-%Y"),")") as description'), 'event.id')->orderBy('event.start_date', 'desc')->pluck('event.description', 'event.id');
        $retreats->prepend('Unassigned', '');

        return view('donations.search', compact('retreats', 'descriptions'));
    }

    public function results(DonationSearchRequest $request): View
    {
        $this->authorize('show-donation');
        if (! empty($request)) {
            $all_donations = Donation::filtered($request)->orderBy('donation_date')->get();
            $donations = Donation::filtered($request)->orderBy('donation_date')->paginate(25, ['*'], 'donations');
            $donations->appends($request->except('page'));
        } else {
            $all_donations = Donation::orderBy('name')->get();
            $donations = Donation::orderBy('name')->paginate(25, ['*'], 'donations');
        }

        return view('donations.results', compact('donations', 'all_donations'));
    }

    public function overpaid(): View
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

    //TODO: add docs code here and create unit tests
    public function mergeable(): View
    {   // contact id 5847 hardcoded for anonymous user
        $this->authorize('show-donation');
        $mergeable = DB::table('Donations as d')
         ->select(DB::raw('CONCAT(d.contact_id,"-",d.event_id,"-",d.donation_description) as unique_value, COUNT(*) as donation_count, MAX(d.donation_date) as donation_date, MIN(d.donation_id) as min_donation_id, MAX(d.donation_id) as max_donation_id, MIN(c.sort_name) as sort_name, MIN(e.idnumber) as idnumber, MIN(e.title) as event_title, MIN(d.donation_description) as donation_description, MIN(d.contact_id) as contact_id'))
         ->leftjoin('event as e', 'd.event_id', '=', 'e.id')
         ->leftjoin('contact as c', 'd.contact_id', '=', 'c.id')
         ->whereRaw('d.deleted_at IS NULL AND d.donation_amount>0 AND d.contact_id IS NOT NULL AND d.event_id IS NOT NULL AND d.donation_description IS NOT NULL AND d.contact_id <> 5847 AND d.donation_date>="2021-07-01"')
         ->groupByRaw('CONCAT(d.contact_id,"-",d.event_id,"-",d.donation_description)')
         ->havingRaw('COUNT(*)>1')->paginate(25, ['*'], 'mergeable');
        // dd($mergeable);
        return view('donations.mergeable', compact('mergeable'));
    }

    //TODO: add docs code here and create unit tests
    public function merge($first_donation_id = 0, $second_donation_id = 0): RedirectResponse
    {
        $this->authorize('update-donation');
        $first_donation = Donation::findOrFail($first_donation_id); // target or destination donation
        $second_donation = Donation::findOrFail($second_donation_id); // source or donation being merged
        $second_donation_payments = Payment::whereDonationId($second_donation_id)->get();

        // verify mergability

        if ($first_donation->contact_id != $second_donation->contact_id) {
            flash('Mismatched Contact IDs: Donation ID#: <a href="'.url('/donation/'.$first_donation->donation_id).'">'.$first_donation->donation_id.'</a> 
            not mergeable with ID# <a href="'.url('/donation/'.$second_donation->donation_id).'">'.$second_donation->donation_id.'</a>')->warning()->important();

            return Redirect::action([self::class, 'mergeable']);
        }

        if ($first_donation->event_id != $second_donation->event_id) {
            flash('Mismatched Event IDs: Donation ID#: <a href="'.url('/donation/'.$first_donation->donation_id).'">'.$first_donation->donation_id.'</a> 
            not mergeable with ID# <a href="'.url('/donation/'.$second_donation->donation_id).'">'.$second_donation->donation_id.'</a>')->warning()->important();

            return Redirect::action([self::class, 'mergeable']);
        }

        if ($first_donation->donation_description != $second_donation->donation_description) {
            flash('Mismatched Donation Descriptions: Donation ID#: <a href="'.url('/donation/'.$first_donation->donation_id).'">'.$first_donation->donation_id.'</a> 
            not mergeable with ID# <a href="'.url('/donation/'.$second_donation->donation_id).'">'.$second_donation->donation_id.'</a>')->warning()->important();

            return Redirect::action([self::class, 'mergeable']);
        }

        // move second donation payments to first donation
        foreach ($second_donation_payments as $second_payment) {
            $second_payment->donation_id = $first_donation_id;
            $second_payment->save();
        }

        // merge donation_amount, Notes and possibly squarespace_order
        $first_donation->donation_amount += $second_donation->donation_amount;
        $first_donation->Notes = (isset($first_donation->Notes)) ? $first_donation->Notes.' '.$second_donation->Notes : $second_donation->Notes;
        $first_donation->squarespace_order = (isset($first_donation->squarespace_order)) ? $first_donation->squarespace_order : $second_donation->squarespace_order;
        $first_donation->save();

        // if there is an existing squarespace contribution for $second_donation, change it to $first_donation to avoid orphaned squarespace contributions which can mess up processing related stripe balance transaction
        $squarespace_contribution = SquarespaceContribution::whereDonationId($second_donation->donation_id)->first();
        if (isset($squarespace_contribution)) {
            $squarespace_contribution->donation_id = $first_donation->donation_id;
            $squarespace_contribution->save();
        }

        // delete the second donation
        $second_donation->delete();

        flash('Donation ID #'.$second_donation_id.' has been merged with Donation ID #<a href="'.url('/donation/'.$first_donation->donation_id).'">'.$first_donation->donation_id.'</a>')->success();

        return Redirect::action([self::class, 'mergeable']);
    }

    public function agc($year, DonationAgcRequest $request): View
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
            $all_donations = Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year.'-07-01')->where('donation_date', '<', $year.'-07-01')->with('contact.prefix', 'contact.suffix', 'contact.agc2019', 'payments')
            ->get();
            $donations = Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year.'-07-01')->where('donation_date', '<', $year.'-07-01')->with('contact.prefix', 'contact.suffix', 'contact.agc2019', 'payments')
            ->paginate(25, ['*'], 'donations');
        } else {
            $all_donations = Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year.'-07-01')->where('donation_date', '<', $year.'-07-01')
                ->with('contact.prefix', 'contact.suffix', 'contact.agc2019', 'payments')->whereNull('Thank you')->get();
            $donations = Donation::orderBy('donation_date', 'desc')->whereIn('donation_description', config('polanco.agc_donation_descriptions'))->where('donation_date', '>=', $prev_year.'-07-01')->where('donation_date', '<', $year.'-07-01')
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
     */
    public function create($id = null, $event_id = null, $type = null): View
    {
        $this->authorize('create-donation');

        $subcontact_type_id = (isset($type)) ? config('polanco.contact_type.'.$type) : null;

        if ($id > 0) {
            $donor = Contact::findOrFail($id); // a lazy way to fail if no donor
            $donor_events = Registration::whereContactId($id)->get();
            $donors = Contact::whereId($id)->pluck('sort_name', 'id');
        } else {
            $donors = Contact::whereContactType(config('polanco.contact_type.individual'))->orderBy('sort_name')->pluck('sort_name', 'id');
        }
        if (isset($subcontact_type_id) && ($id == 0)) {
            $donors = Contact::whereSubcontactType($subcontact_type_id)->orderBy('sort_name')->pluck('sort_name', 'id');
        }
        if (isset($event_id)) {
            $retreats = Retreat::findOrFail($event_id); // a lazy way to fail if unknown event_id
            $retreats = Retreat::select(DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->whereId($event_id)->pluck('description', 'id');
        } else {
            // $retreats = Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("is_active", "=", 1)->orderBy('start_date')->pluck('description', 'id');
            $retreats = Registration::leftjoin('event', 'participant.event_id', '=', 'event.id')->select(DB::raw('CONCAT(event.idnumber, "-", event.title, " (",DATE_FORMAT(event.start_date,"%m-%d-%Y"),")") as description'), 'event.id')->whereContactId($id)->orderBy('event.start_date', 'desc')->pluck('event.description', 'event.id');
            $retreats->prepend('Unassigned', 0);
        }

        //dd($donors);
        $payment_methods = config('polanco.payment_method');
        $descriptions = DonationType::active()->orderby('name')->pluck('name', 'name');
        $dt_today = \Carbon\Carbon::today();
        $defaults['today'] = $dt_today->month.'/'.$dt_today->day.'/'.$dt_today->year;
        $defaults['retreat_id'] = $event_id;

        return view('donations.create', compact('retreats', 'donors', 'descriptions', 'payment_methods', 'defaults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     *
     * authorize (permission check)
     * validate input
     * create and save new donation record
     * redirect to donation.index
     */
    public function store(StoreDonationRequest $request): RedirectResponse
    {
        $this->authorize('create-donation');

        $donation = new Donation;
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
        $payment = new Payment;
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
     */
    public function show(int $id): View
    {
        $this->authorize('show-donation');
        $donation = Donation::with('payments', 'contact')->findOrFail($id);

        return view('donations.show', compact('donation')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->authorize('update-donation');
        //get this retreat's information
        $donation = Donation::with('payments', 'contact')->findOrFail($id);
        $descriptions = DonationType::active()->orderby('name')->pluck('name', 'name');

        if (! $descriptions->search($donation->donation_description)) {
            $descriptions->prepend($donation->donation_description.' (inactive donation type)', $donation->donation_description);
            // dd($descriptions,$donation->donation_description);
        }

        // $retreats = Retreat::select(\DB::raw('CONCAT_WS(" ",CONCAT(idnumber," -"), title, CONCAT("(",DATE_FORMAT(start_date,"%m-%d-%Y"),")")) as description'), 'id')->where("end_date", ">", $donation->donation_date)->where("is_active", "=", 1)->orderBy('start_date')->pluck('description', 'id');
        $retreats = Registration::leftjoin('event', 'participant.event_id', '=', 'event.id')->select(DB::raw('CONCAT(event.idnumber, "-", event.title, " (",DATE_FORMAT(event.start_date,"%m-%d-%Y"),")") as description'), 'event.id')->whereContactId($donation->contact_id)->orderBy('event.start_date', 'desc')->pluck('event.description', 'event.id');

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
     */
    public function update(UpdateDonationRequest $request, int $id): RedirectResponse
    {
        $this->authorize('update-donation');

        $donation = Donation::findOrFail($id);
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
        $donation->stripe_invoice = $request->input('stripe_invoice');
        if ($request->input('donation_thank_you') == 'Y') {
            $donation['Thank You'] = $request->input('donation_thank_you'); //field has space in database and should be changed at some point
        } else {
            $donation['Thank You'] = null;
        }
        $donation->save();

        flash('Donation ID#: <a href="'.url('/donation/'.$donation->donation_id).'">'.$donation->donation_id.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $donation->donation_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('delete-donation');
        $donation = Donation::findOrFail($id);
        $contact = Contact::findOrFail($donation->contact_id);
        //deletion of payments implied on the model
        Donation::destroy($id);
        // disassociate registration with a donation that is being deleted - there should only be one
        $registration = Registration::whereDonationId($id)->first();
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
     */
    public function retreat_payments_update(Request $request): RedirectResponse
    {   // I removed the permission check for update-payment as it seemed redundant to update-donation and it makes testing a little easier
        $this->authorize('update-donation');
        if ($request->input('event_id')) {
            $event_id = $request->input('event_id');
        }
        if (! is_null($request->input('donations'))) {
            foreach ($request->input('donations') as $key => $value) {
                $registration = Registration::findOrFail($key);
                // if there is not already an existing donation and there is a pledge
                if (is_null($registration->donation_id)) { //create a new donation
                    if ($value['pledge'] > 0) {
                        $donation = new Donation;
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
                        $payment = new Payment;
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
                    $donation = Donation::findOrFail($registration->donation_id); // update an existing donation
                    $donation->donation_amount = $value['pledge'];
                    $donation->terms = $value['terms'];
                    $donation->save();
                }
            }
        }

        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $request->input('event_id'));
    }

    // TODO:: add unit test for this method
    public function process_deposits($event_id): RedirectResponse
    {
        $this->authorize('update-donation');
        $event = Retreat::findOrFail($event_id);
        $event_deposits = Donation::whereEventId($event_id)->whereDonationDescription('Retreat Deposits')->get();
        foreach ($event_deposits as $event_deposit) {
            try {
                $event_deposit->donation_description = 'Retreat Funding';
                $event_deposit->Notes = 'Automated deposit to funding transfer processed. '.$event_deposit->Notes;
                $event_deposit->save();
            } catch (\Exception $e) {
                dd($e);
            }
        }

        flash('Retreat Donations Processed for ID#: <a href="'.url('/retreat/'.$event_id).'">'.$event->idnumber.' - '.$event->title.'</a>')->success();

        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $event_id);
    }

        // TODO:: add unit test for this method; creating method as proof of concept - need to come back and test
        public function unprocess_deposits($event_id): RedirectResponse
        {
            $this->authorize('update-donation');
            $event = Retreat::findOrFail($event_id);
            $event_deposits = Donation::whereEventId($event_id)->whereDonationDescription('Retreat Funding')->get();
            foreach ($event_deposits as $event_deposit) {
                try {
                    if (strpos($event_deposit->Notes, 'Automated deposit to funding transfer processed.') === 0) {
                        // string not found; skip
                    } else {
                        $event_deposit->donation_description = 'Retreat Deposit';
                        $event_deposit->Notes = 'Automated deposit to funding transfer processed. '.$event_deposit->Notes;
//                        $event_deposit->save();
                    }
                } catch (\Exception $e) {
                    dd($e);
                }
            }

            flash('Retreat Donations Unprocessed for ID#: <a href="'.url('/retreat/'.$event_id).'">'.$event->idnumber.' - '.$event->title.'</a>')->success();

            return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $event_id);
        }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
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
    public function about()
    {
        return view('pages.about');   //
    }

    public function retreat()
    {
        return view('pages.retreat');   //
    }

    public function reservation()
    {
        return view('pages.reservation');   //
    }

    public function room()
    {
        return view('pages.room');   //
    }

    public function housekeeping()
    {
        return view('pages.housekeeping');   //
    }

    public function maintenance()
    {
        return view('pages.maintenance');   //
    }

    public function grounds()
    {
        return view('pages.grounds');   //
    }

    public function kitchen()
    {
        return view('pages.kitchen');   //
    }

    public function finance()
    {
        return view('pages.finance');   //
    }

    public function bookstore()
    {
        return view('pages.bookstore');   //
    }

    public function user()
    {
        return view('pages.user');   //
    }

    public function restricted()
    {
        return view('pages.restricted');   //
    }

    public function support()
    {
        return view('pages.support');   //
    }

    public function welcome()
    {
        $next_week = (Carbon::now()->addWeeks(1));
        $client = new \GuzzleHttp\Client();
        $result = $client->get('http://labs.bible.org/api/?passage=random')->getBody();
        $quote = strip_tags($result->getContents(), '<b>');
        // $retreats = \App\Retreat::where('start_date', '<=', $next_week)->where('end_date', '>=', date('Y-m-d'))->orderBy('start_date')->get();
        return view('welcome', compact('quote'));   //
    }

    public function retreatantinforeport($id)
    {
        $this->authorize('show-contact');
        $this->authorize('show-registration');
        $retreat = \App\Retreat::where('idnumber', '=', $id)->first();
        //unsorted registrations
        //$registrations = \App\Registration::where('event_id','=',$retreat->id)->with('retreat','retreatant.languages','retreatant.parish.contact_a.address_primary','retreatant.prefix','retreatant.suffix','retreatant.address_primary.state','retreatant.phones.location','retreatant.emails.location','retreatant.emergency_contact','retreatant.notes','retreatant.occupation')->get();
        //registrations sorted by contact's sort_name
        $registrations = \App\Registration::select(\DB::raw('participant.*', 'contact.*'))
                ->join('contact', 'participant.contact_id', '=', 'contact.id')
                ->where('participant.event_id', '=', $retreat->id)
                ->whereCanceledAt(null)
                ->with('retreat', 'retreatant.languages', 'retreatant.parish.contact_a.address_primary', 'retreatant.prefix', 'retreatant.suffix', 'retreatant.address_primary.state', 'retreatant.phones.location', 'retreatant.emails.location', 'retreatant.emergency_contact', 'retreatant.notes', 'retreatant.occupation')
                ->orderBy('contact.sort_name', 'asc')
                ->orderBy('participant.notes', 'asc')
                ->get();

        return view('reports.retreatantinfo2', compact('registrations'));   //
    }

    public function contact_info_report($id)
    {
        $this->authorize('show-contact');
        $person = \App\Contact::findOrFail($id);

        return view('reports.contact_info', compact('person'));   //
    }

    public function finance_cash_deposit($day = null)
    {
        $this->authorize('show-donation');
        if (is_null($day)) {
            $day = Carbon::now();
        }
        $report_date = Carbon::parse($day);
        if (isset($report_date)) {
            $payments = \App\Payment::wherePaymentDate($report_date)->whereIn('payment_description', ['Cash', 'Check'])->with('donation')->get();
            $grand_total = $payments->sum('payment_amount');
            $grouped_payments = $payments->sortBy('donation.donation_description')->groupBy('donation.donation_description');
            // dd($report_date, $grouped_payments,$grand_total);
        return view('reports.finance.cash_deposit', compact('report_date', 'grouped_payments', 'grand_total'));   //
        } else {
            return back(); //
        }
    }

    public function finance_cc_deposit($day = null)
    {
        $this->authorize('show-donation');
        if (is_null($day)) {
            $day = Carbon::now();
        }
        $report_date = Carbon::parse($day);
        if (isset($report_date)) {
            $payments = \App\Payment::wherePaymentDate($report_date)->where('payment_description', '=', 'Credit Card')->with('donation')->get();
            $grand_total = $payments->sum('payment_amount');
            $grouped_payments = $payments->sortBy('donation.donation_description')->groupBy('donation.donation_description');
            //dd($report_date, $grouped_payments,$grand_total);
        return view('reports.finance.cc_deposit', compact('report_date', 'grouped_payments', 'grand_total'));   //
        } else {
            return back(); //
        }
    }

    public function finance_invoice($donation_id = null)
    {
        $this->authorize('show-donation');

        $donation = \App\Donation::with('payments', 'contact', 'retreat')->findOrFail($donation_id);
        // dd($donation);
    return view('reports.finance.invoice', compact('donation'));   //
    }

    public function finance_agcacknowledge(Request $request, $donation_id = null)
    {
        $this->authorize('show-donation');
        $current_user = $request->user();
        $user_email = \App\Email::whereEmail($current_user->email)->first();

        $donation = \App\Donation::with('payments', 'contact', 'retreat')->findOrFail($donation_id);
        if (null == $donation['Thank You']) { //avoid creating another touchpoint if acknowledgement letter has already been viewed (and presumably printed and mailed)
            $agc_touchpoint = new \App\Touchpoint;
            $agc_touchpoint->person_id = $donation->contact_id;
            $agc_touchpoint->staff_id = $user_email->contact_id;
            $agc_touchpoint->touched_at = Carbon::parse(now());
            $agc_touchpoint->type = 'Letter';
            $agc_touchpoint->notes = 'AGC Acknowledgement Letter for Donation #'.$donation->donation_id;
            $agc_touchpoint->save();
            $donation['Thank You'] = 'Y';
            $donation->save();
        }
        //dd($donation->contact->preferred_language_value);
        if ($donation->contact->preferred_language_value == 'es') {
            $dt = Carbon::now();
            $donation['today_es'] = $dt->day.' de '.$dt->locale('es')->monthName.' del '.$dt->year;
            $donation['donation_date_es'] = $donation->donation_date->day.' de '.$donation->donation_date->locale('es')->monthName.' del '.$donation->donation_date->year;

            return view('reports.finance.agcacknowledge_es', compact('donation'));
        } else {
            return view('reports.finance.agcacknowledge', compact('donation'));
        }
        //
    }

    public function finance_retreatdonations($retreat_id = null)
    {
        $this->authorize('show-donation');
        if (is_null($retreat_id)) {
            $retreat_id = null;
        }
        $retreat = \App\Retreat::whereIdnumber($retreat_id)->firstOrFail();
        if (isset($retreat)) {
            $donations = \App\Donation::whereEventId($retreat->id)->with('contact', 'payments')->get();
            $grouped_donations = $donations->sortBy('donation_description')->groupBy('donation_description');
            //dd($retreat,$grouped_donations);
        return view('reports.finance.retreatdonations', compact('retreat', 'grouped_donations', 'donations'));   //
        } else {
            return back(); //
        }
    }

    public function finance_deposits()
    {
        $this->authorize('show-donation');
        $donations = \App\Donation::where('donation_description', 'Deposit')->whereDeletedAt(null)->where('donation_amount', '>', 0)->with('contact', 'payments', 'retreat')->get();
        $payments = \App\Payment::whereHas('donation', function ($query) {
            $query->where('donation_description', '=', 'Deposit');
        })
        ->whereHas('donation', function ($query) {
            $query->where('donation_amount', '>', 0);
        })->with('donation.retreat', 'donation.contact')->get();
        $grouped_payments = $payments->groupBy(function ($c) {
            return '#'.$c->donation->retreat_idnumber.'-'.$c->donation->retreat_name.' ('.$c->donation->retreat_start_date.')';
        })->sortBy(function ($d) {
            return Carbon::parse($d[0]->donation->retreat_start_date);
        });

        return view('reports.finance.deposits', compact('grouped_payments', 'payments'));
    }

    public function finance_reconcile_deposit_show($event_id = null)
    {
        $this->authorize('show-donation');
        $this->authorize('show-registration');
        if (! isset($event_id)) {
            $event_id = 1422; //open deposit retreat id - currently hardcoded
        }

        $payments = \App\Payment::where('payment_amount', '>', 0)
       ->whereHas('donation', function ($query) {
           $query->where('donation_description', '=', 'Deposit');
       })
       ->whereHas('donation', function ($query) use ($event_id) {
           $query->where('event_id', '=', $event_id);
       })
       ->whereHas('donation', function ($query) {
           $query->where('donation_amount', '>', 0);
       })->with('donation.retreat', 'donation.contact')->get();
        $grouped_payments = $payments->groupBy(function ($c) {
            return '#'.$c->donation->retreat_idnumber.'-'.$c->donation->retreat_name.' ('.$c->donation->retreat_start_date.')';
        })->sortBy(function ($d) {
            return Carbon::parse($d[0]->donation->retreat_start_date);
        });
        $registrations = \App\Registration::whereEventId($event_id)->whereCanceledAt(null)->orderBy('contact_id')->get();
        $pg = $payments->groupBy('donation.contact_id')->sortBy('donation.contact_id');
        $rg = $registrations->groupBy('contact_id')->sortBy('contact_id');
        $diffpg = $pg->diffKeys($rg); //payments with no registration
       $diffrg = $rg->diffKeys($pg); //regisrations with no payments
       // dd($pg, $rg, $diffpg, $diffrg);
       return view('reports.finance.reconcile_deposits', compact('diffpg', 'diffrg'));
    }

    public function retreatlistingreport($id)
    {
        $this->authorize('show-contact');

        $retreat = \App\Retreat::where('idnumber', '=', $id)->first();
        //$registrations = \App\Registration::where('event_id','=',$retreat->id)->with('retreat','retreatant')->get();
        $registrations = \App\Registration::select(\DB::raw('participant.*', 'contact.*'))
                ->join('contact', 'participant.contact_id', '=', 'contact.id')
                ->where('participant.event_id', '=', $retreat->id)
                ->whereCanceledAt(null)
                ->with('retreat', 'retreatant.languages', 'retreatant.parish.contact_a.address_primary', 'retreatant.prefix', 'retreatant.suffix', 'retreatant.address_primary.state', 'retreatant.phones.location', 'retreatant.emails.location', 'retreatant.emergency_contact', 'retreatant.notes', 'retreatant.occupation')
                ->orderBy('contact.sort_name', 'asc')
                ->orderBy('participant.notes', 'asc')
                ->get();

        return view('reports.retreatlisting', compact('registrations'));   //
    }

    public function retreatrosterreport($id)
    {
        $this->authorize('show-contact');
        $retreat = \App\Retreat::where('idnumber', '=', $id)->first();
        //        $registrations = \App\Registration::where('event_id','=',$retreat->id)->with('retreat','retreatant.suffix','retreatant.address_primary','retreatant.prefix')->get();
        //dd($registrations);
        $registrations = \App\Registration::select(\DB::raw('participant.*', 'contact.*'))
                ->join('contact', 'participant.contact_id', '=', 'contact.id')
                ->where('participant.event_id', '=', $retreat->id)
                ->whereCanceledAt(null)
                ->with('retreat', 'retreatant.languages', 'retreatant.parish.contact_a.address_primary', 'retreatant.prefix', 'retreatant.suffix', 'retreatant.address_primary.state', 'retreatant.phones.location', 'retreatant.emails.location', 'retreatant.emergency_contact', 'retreatant.notes', 'retreatant.occupation')
                ->orderBy('contact.sort_name', 'asc')
                ->orderBy('participant.notes', 'asc')
                ->get();

        return view('reports.retreatroster', compact('registrations'));   //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function config_google_client()
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.google_client');
    }

    public function config_mailgun()
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.mailgun');
    }

    public function config_twilio()
    {
        $this->authorize('show-admin-menu');

        return view('admin.config.twilio');
    }
}

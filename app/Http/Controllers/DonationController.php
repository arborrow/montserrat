<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('confirmAttendance');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-donation');
        $donations = \App\Donation::orderBy('donation_date', 'desc')->with('contact')->paginate(100);
        //dd($donations);
        return view('donations.index', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = NULL, $event_id = NULL, $type = NULL)
    {
        $this->authorize('create-donation');
        
        $subcontact_type_id = config('polanco.contact_type.'.$type);
        // dd($subcontact_type_id,$id);
        if ($id>0) {
            $donor = \App\Contact::findOrFail($id); // a lazy way to fail if no donor
            $donors = \App\Contact::whereId($id)->pluck('sort_name','id');
        } else {
            $donors = \App\Contact::whereContactType(config('polanco.contact_type.individual'))->orderBy('sort_name')->pluck('sort_name', 'id');
        }
        if (isset($subcontact_type_id) && ($id==0)) {
            $donors = \App\Contact::whereSubcontactType($subcontact_type_id)->orderBy('sort_name')->pluck('sort_name', 'id');
        }
        if (isset($event_id)) {
            $retreats = \App\Retreat::findOrFail($event_id);
            $retreats = \App\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->whereId($event_id)->pluck('description', 'id');
            
        } else {
            $retreats = \App\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date", ">", \Carbon\Carbon::today()->subWeek())->where("is_active", "=", 1)->orderBy('start_date')->pluck('description', 'id');
            $retreats->prepend('Unassigned', 0);
        }
        
        //dd($donors);
        $payment_methods = config('polanco.payment_method');
        $descriptions = \App\DonationType::orderby('name')->pluck('name', 'name');
        $dt_today =  \Carbon\Carbon::today();
        $defaults['today'] = $dt_today->month.'/'.$dt_today->day.'/'.$dt_today->year;
        $defaults['retreat_id']= $event_id;

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
     * 
     */
    public function store(Request $request)
    {   
        $this->authorize('create-donation');
        
        $this->validate($request, [
        'donor_id' => 'required|integer|min:0',
        'event_id' => 'integer|min:0',
        'donation_date' => 'required|date',
        'donation_amount' => 'required|numeric|min:0',
        'payment_amount' => 'required|numeric|min:0',
        'payment_idnumber' => 'nullable|numeric|min:0',
        'start_date' => 'date|nullable|before:end_date',
        'end_date' => 'date|nullable|after:start_date',
        'donation_install' => 'integer|min:0|nullable'
        ]);

        $donation = new \App\Donation;
        $donation->contact_id= $request->input('donor_id');
        $donation->event_id = $request->input('event_id');
        $donation->donation_date= Carbon::parse($request->input('donation_date'));
        $donation->donation_amount = $request->input('donation_amount');
        $donation->donation_description = $request->input('donation_description');
        $donation->Notes= $request->input('notes');
        $donation->terms= $request->input('terms');
        $donation->start_date= $request->input('start_date_only');
        $donation->end_date= $request->input('end_date_only');
        $donation->donation_install = $request->input('donation_install');
        $donation->save();
        
         // create donation_payments
        $payment = new \App\Payment;
        $payment->donation_id = $donation->donation_id;
        $payment->payment_amount = $request->input('payment_amount');
        $payment->payment_date = Carbon::now()->toDateString();
        $payment->payment_description = $request->input('payment_description'); 
        if ($request->input('payment_description') == 'Credit card') {
            $payment->ccnumber = substr($request->input('payment_idnumber'),-4);
        }
        if ($request->input('payment_description') == 'Check') {
            $payment->cknumber = $request->input('payment_idnumber');
        }
        //dd($payment, $donation);
        $payment->save();

        
        return Redirect::action('DonationController@index');
          
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
        $donation= \App\Donation::with('payments', 'contact')->findOrFail($id);
        return view('donations.show', compact('donation'));//
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
        $donation = \App\Donation::with('payments', 'contact')->findOrFail($id);
        $descriptions = \App\DonationType::orderby('name')->pluck('name', 'id');

        $retreats = \App\Retreat::select(\DB::raw('CONCAT(idnumber, "-", title, " (",DATE_FORMAT(start_date,"%m-%d-%Y"),")") as description'), 'id')->where("end_date", ">", $donation->donation_date)->where("is_active", "=", 1)->orderBy('start_date')->pluck('description', 'id');
        $retreats->prepend('Unassigned', 0);
        $defaults['event_id'] = $donation->event_id;
        $descriptions->prepend('Unassigned', 0);
        //$descriptions->toArray();
        $defaults['description_key'] = $descriptions->search($donation->donation_description);
        // dd($defaults);
        return view('donations.edit', compact('donation','descriptions','defaults','retreats'));
    }

    /**
     * Update the specified resource in storage.
        $defaults['description_key'] = array_search($donation->donation_description, $descriptions->toArray());
        return view('donations.edit', compact('donation','descriptions','defaults','retreats'));
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
        $this->authorize('update-donation');
        
        $this->validate($request, [
        'donor_id' => 'required|integer|min:0',
        'event_id' => 'integer|min:0',
        'donation_date' => 'required|date',
        'donation_amount' => 'required|integer|min:0',
        'start_date' => 'date|nullable|before:end_date',
        'end_date' => 'date|nullable|after:start_date',
        'donation_install' => 'integer|min:0|nullable'
        ]);
        //dd($request->input('donation_description'));
        if ($request->input('donation_description')>0) {
            $donation_description = \App\DonationType::find($request->input('donation_description'));
        
        }
        // dd($donation_description);
        $donation = \App\Donation::findOrFail($id);
        $donation->contact_id= $request->input('donor_id');
        $donation->event_id= $request->input('event_id');
        $donation->donation_date= $request->input('donation_date') ? Carbon::parse($request->input('donation_date')) : NULL;
        $donation->donation_amount= $request->input('donation_amount');
        if (isset($donation_description)) {
            $donation->donation_description = $donation_description->label;
        }
        $donation->notes1= $request->input('notes1'); //primary_contact
        $donation->notes= $request->input('notes');
        $donation->terms= $request->input('terms');
        $donation->start_date= $request->input('start_date_only') ? Carbon::parse($request->input('start_date_only')) : NULL;
        $donation->end_date= $request->input('end_date_only') ? Carbon::parse($request->input('end_date_only')) : NULL;
        $donation->donation_install = $request->input('donation_install');
        
        $donation->save();
        
        return Redirect::action('DonationController@index');
          
    
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
        $donation= \App\Donation::findOrFail($id);
        //deletion of payments implied on the model 
        \App\Donation::destroy($id);
        // disassociate registration with a donation that is being deleted - there should only be one
        $registration = \App\Registration::whereDonationId($id)->first();
        if (isset($registration->donation_id)) {
            $registration->donation_id = NULL;
            $registration->save();
        }
                
        return Redirect::action('DonationController@index');

    }
    
     /**
     * Process retreat payments from retreat.payments 
     *
     * @param  \Illuminate\Http\Request  $request
     * $request contains a $donations array with fields for id, pledge, paid, method and terms
      * this method will only be used for retreat offerings - other types of donations should be handled elsewhere
      * primary use is for creating retreat offering donations but will have ability to edit existing retreat offerings 
     * @return \Illuminate\Http\Response
     */
    public function retreat_payments_update(Request $request)
    {   $this->authorize('update-donation');
        $this->authorize('update-payment');
        $event_id = $request->input('event_id');
        if (!is_null($request->input('donations'))) {
            foreach ($request->input('donations') as $key => $value) {
                $registration = \App\Registration::findOrFail($key);
                // if there is not already an existing donation and there is a pledge
                if (is_null($registration->donation_id))  { //create a new donation
                    if ($value['pledge']>0) {
                        $donation = new \App\Donation; 
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

                        $donation->donation_description = 'Retreat Offering'; // this page/method is only handling retreat offerings
                        $donation->donation_date = $registration->retreat_end_date;
                        $donation->donation_amount = $value['pledge'];
                        $donation->terms = $value['terms'];
                        $donation->save();
                        $registration->donation_id = $donation->donation_id;
                        $registration->save();

                        // create donation_payments
                        $payment = new \App\Payment;
                        $payment->donation_id = $donation->donation_id;
                        $payment->payment_amount = $value['paid'];
                        $payment->payment_date = $donation->donation_date;
                        $payment->payment_description = $value['method']; 
                        if ($value['method'] == 'Credit card') {
                            $payment->ccnumber = substr($value['idnumber'],-4);
                        }
                        if ($value['method'] == 'Check') {
                            $payment->cknumber = $value['idnumber'];
                        }
                        //dd($payment, $donation);
                        $payment->save();
                    }
                } else {
                    $donation = \App\Donation::findOrFail($registration->donation_id); // update an existing donation
                    $donation->donation_amount = $value['pledge'];
                    $donation->terms = $value['terms'];
                    $donation->save();
                        
                    
                }
                
            }
        }
        
        return Redirect::action('RetreatController@show',$request->input('event_id'));
    }

}
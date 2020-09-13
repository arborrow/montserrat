<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
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
        $this->authorize('show-payment');
        $payments = \App\Payment::orderBy('payment_date', 'desc')->with('donation.retreat')->paginate(100);
        //dd($donations);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * Rather than complicating the interface by selecting a donation
     * I am choosing to require the donation_id to create a payment
     *
     * @return \Illuminate\Http\Response
     */
    public function create($donation_id=0)
    {   if ($donation_id > 0) {
            $this->authorize('create-payment');
            $donation = \App\Donation::findOrFail($donation_id);
            $payment_methods = config('polanco.payment_method');

            return view('payments.create', compact('donation', 'payment_methods'));
        } else {
            flash('Cannot create a payment without an associated Donation ID#')->error()->important();
            return Redirect::action('DonationController@index');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {
        $this->authorize('create-payment');
        // dd($request);

        $donation = \App\Donation::findOrFail($request->input('donation_id'));
        // create donation_payment
        $payment = new \App\Payment;
        $payment->donation_id = $donation->donation_id;
        $payment->payment_amount = $request->input('payment_amount');
        $payment->note = $request->input('note');
        $payment->payment_date = Carbon::parse($request->input('payment_date'));
        $payment->payment_description = $request->input('payment_description');
        if ($request->input('payment_description') == 'Credit card') {
            $payment->ccnumber = substr($request->input('payment_idnumber'), -4);
        }
        if ($request->input('payment_description') == 'Check'  || $request->input('payment_description') == 'Refund' ) {
            $payment->cknumber = $request->input('payment_idnumber');
        }
        $payment->save();

        flash('Payment ID#: <a href="'. url('/payment/'.$payment->payment_id) . '">'.$payment->payment_id.'</a> added')->success();
        return Redirect::action('DonationController@show', $donation->donation_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-payment');
        $payment = \App\Payment::with('donation.retreat', 'donation.contact')->findOrFail($id);
        //dd($donation);
        return view('payments.show', compact('payment')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-payment');
        //get this retreat's information
        $payment = \App\Payment::with('donation.contact', 'donation.retreat')->findOrFail($id);
        $payment_methods = config('polanco.payment_method');

        return view('payments.edit', compact('payment', 'payment_methods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, $id)
    {
        $this->authorize('update-payment');

        $payment = \App\Payment::findOrFail($id);
        $payment->payment_amount = $request->input('payment_amount');
        $payment->payment_date = Carbon::parse($request->input('payment_date'));
        $payment->payment_description = $request->input('payment_description');
        if ($request->input('payment_description') == 'Credit card') {
            $payment->ccnumber = substr($request->input('payment_idnumber'), -4);
        }
        if ($request->input('payment_description') == 'Check'  || $request->input('payment_description') == 'Refund' ) {
            $payment->cknumber = $request->input('payment_idnumber');
        }
        $payment->note = $request->input('note');
        // dd($payment);
        $payment->save();

        flash('Payment ID#: <a href="'. url('/payment/'.$payment->payment_id) . '">'.$payment->payment_id.'</a> updated')->success();
        return Redirect::action('DonationController@show', $payment->donation_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-payment');
        $payment = \App\Payment::findOrFail($id);

        \App\Payment::destroy($id);
        // disassociate registration with a donation that is being deleted - there should only be one

        flash('Payment ID#: '.$payment->payment_id . ' deleted')->warning()->important();
        return Redirect::action('DonationController@show', $payment->donation_id);
    }
}

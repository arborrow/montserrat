<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-stripe-charge');

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $charges = $stripe->charges->all([]);

        return view('stripe.charges.index',compact('charges'));   //

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
    public function show($charge_id)
    {
        $this->authorize('show-stripe-charge');

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $charge = $stripe->charges->retrieve($charge_id,[]);
        // $invoice = $stripe->invoices->retrieve($charge->invoice,[]);
        $customer = !is_null($charge->customer) ? $stripe->customers->retrieve($charge->customer) : NULL;

        return view('stripe.charges.show',compact('charge','customer'));

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import($id)
    {
        $this->authorize('import-stripe-charge');
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $charges = $stripe->charges->all([]);
        foreach ($charges->autoPagingIterator() as $charge) {
            // TODO: create stripe_charge model, check if charge->id exists, if not insert/import it
        }


    }

}

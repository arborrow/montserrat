<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StripeChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('show-stripe-charge');

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $charges = $stripe->charges->all([]);

        return view('stripe.charges.index', compact('charges'));   //
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
     */
    public function show($charge_id): View
    {
        $this->authorize('show-stripe-charge');

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $charge = $stripe->charges->retrieve($charge_id, []);
        // $invoice = $stripe->invoices->retrieve($charge->invoice,[]);
        $customer = ! is_null($charge->customer) ? $stripe->customers->retrieve($charge->customer) : null;

        return view('stripe.charges.show', compact('charge', 'customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(int $id)
    {
        $this->authorize('import-stripe-charge');
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $charges = $stripe->charges->all([]);
        foreach ($charges->autoPagingIterator() as $charge) {
            // TODO: create stripe_charge model, check if charge->id exists, if not insert/import it
        }
    }
}

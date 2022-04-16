<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-stripe-payout');

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $payouts = $stripe->payouts->all(['limit' => 10]);
        // $reports = $stripe->reporting->reportTypes->all([]);

        // $payout = $stripe->payouts->retrieve('po_1KWAO8JPvjW38HM4LT0HYmDX',[]);

        // $transfers = $stripe->transfers->all(['limit' => 10]);

        /* $balance_transactions = $stripe->balanceTransactions->all(
            ['payout' => $payout->id,
            'type' => 'charge',
            'limit' => 100,
            ]
        );
        */

        // foreach ($customers->autoPagingIterator() as $customer) {}

        // $payout_report = $stripe->reporting->reportTypes->retrieve(
        //    'ending_balance_reconciliation.itemized.4',[]
        // );

        // $report = $stripe->reporting->reportRuns->retrieve('frr_1KofWcJPvjW38HM4QXghpsEK');


        return view('stripe.payouts.index',compact('payouts'));   //

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
    public function show($payout_id)
    {
        $this->authorize('show-stripe-payout');

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        $payout = $stripe->payouts->retrieve($payout_id,[]);
        $transactions = $stripe->balanceTransactions->all(
            ['payout' => $payout->id,
            'type' => 'charge',
            'limit' => 100,
            ]
        );

        return view('stripe.payouts.show',compact('payout','transactions'));   //

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
}

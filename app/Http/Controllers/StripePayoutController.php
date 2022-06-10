<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StripePayout;
use Carbon\Carbon;
use Stripe\StripeClient;

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

        $stripe = new StripeClient(config('services.stripe.secret'));

        $payouts = StripePayout::orderByDesc('date')->paginate();

        // $payouts = $stripe->payouts->all(['limit' => 10]);

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

        $stripe = new StripeClient(config('services.stripe.secret'));
        $payout = $stripe->payouts->retrieve($payout_id,[]);
        $transactions = $stripe->balanceTransactions->all(
            ['payout' => $payout->id,
            'type' => 'charge',
            'limit' => 100,
            ]
        );

        $fees = 0;
        foreach ($transactions as $transaction) {
            $fees += ($transaction->fee/100);
        }
        $stripe_payout = StripePayout::wherePayoutId($payout_id)->first();
        $stripe_payout->total_fee_amount = $fees;
        $stripe_payout->save();

        return view('stripe.payouts.show',compact('payout','transactions','stripe_payout'));   //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_date($date = null)
    {
        $this->authorize('show-stripe-payout');
        $payout_date = \Carbon\Carbon::parse($date);
        if (empty($payout_date)) {
            return redirect()->back();
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        $stripe_payout = StripePayout::where('date','=',$payout_date)->first();

        $payout = $stripe->payouts->retrieve($stripe_payout->payout_id,[]);

        $transactions = $stripe->balanceTransactions->all(
            ['payout' => $stripe_payout->payout_id,
            'type' => 'charge',
            'limit' => 100,
            ]
        );


        foreach ($transactions as $transaction) {
            if (!(strpos($transaction->description, "Invoice") === false)) {
                $charge = $stripe->charges->retrieve($transaction->source, []);
                $customer = $stripe->customers->retrieve($charge->customer, []);
                $transaction->customer = $customer->description;
                // dd($transaction,$charge,$customer);
            }
            // dd((strpos($transaction->description, "Invoice") === false) );
        }


        return view('stripe.payouts.show',compact('payout','transactions','stripe_payout'));   //

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
     * Import Stripe Payouts into stripe_payout table
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $this->authorize('import-stripe-payout');
        // dd('Stripe Payout Import');
        $stripe = new StripeClient(config('services.stripe.secret'));
        $payouts = $stripe->payouts->all([]);
        foreach ($payouts->autoPagingIterator() as $payout) {

            $stripe_payout = StripePayout::wherePayoutId($payout->id)->first();

            if (is_null($stripe_payout)) {
                $stripe_payout = new StripePayout;
            }

            $stripe_payout->payout_id = $payout->id;
            $stripe_payout->object = $payout->object;
            $stripe_payout->amount = $payout->amount/100;
            $stripe_payout->arrival_date = Carbon::parse($payout->arrival_date);
            $stripe_payout->date = Carbon::parse($payout->arrival_date);
            $stripe_payout->status = $payout->status;
            // TODO: import payment fees and sum together to calculate total_fee_amount for each payout


            $fees = 0; //initialize
            $transactions = $stripe->balanceTransactions->all(
                ['payout' => $stripe_payout->payout_id,
                'type' => 'charge',
                'limit' => 100,
                ]
            );

            foreach ($transactions->autoPagingIterator() as $transaction) {
                $fees += ($transaction->fee/100);
            }

            $stripe_payout->total_fee_amount = $fees;
            $stripe_payout->save();
            //dd($stripe_payout,$payout->id);
        }

        return view('stripe.payouts.index',compact('payouts'));   //

    }

    /**
     * Process Stripe Payout into stripe_charge table
     *
     * @return \Illuminate\Http\Response
     */
    public function process($id)
    {
        $this->authorize('import-stripe-payout');
        // dd('Stripe Payout Import');
        $stripe = new StripeClient(config('services.stripe.secret'));
        $payouts = $stripe->payouts->all([]);
        foreach ($payouts->autoPagingIterator() as $payout) {

            $stripe_payout = StripePayout::wherePayoutId($payout->id)->first();

            if (is_null($stripe_payout)) {
                $stripe_payout = new StripePayout;
            }

            $stripe_payout->payout_id = $payout->id;
            $stripe_payout->object = $payout->object;
            $stripe_payout->amount = $payout->amount/100;
            $stripe_payout->arrival_date = Carbon::parse($payout->arrival_date);
            $stripe_payout->date = Carbon::parse($payout->arrival_date);
            $stripe_payout->status = $payout->status;
            // TODO: import payment fees and sum together to calculate total_fee_amount for each payout
            //$stripe_payout->total_fee_amount = 0;
            $stripe_payout->save();
            //dd($stripe_payout,$payout->id);
        }

        return view('stripe.payouts.index',compact('payouts'));   //

    }

}

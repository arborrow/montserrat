<?php

namespace App\Http\Controllers;

use App\Models\StripeBalanceTransaction;
use App\Traits\SquareSpaceTrait;
use Illuminate\Http\Request;

class StripeBalanceTransactionController extends Controller

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
        $this->authorize('show-stripe-balance-transaction');

        $processed_balance_transactions = StripeBalanceTransaction::whereNotNull('reconcile_date')->orderBy('created_at')->paginate(25, ['*'], 'processed_balance_transactions');
        $unprocessed_balance_transactions = StripeBalanceTransaction::whereNull('reconcile_date')->orderByDesc('created_at')->paginate(25, ['*'], 'unprocessed_balance_transactions');

        return view('stripe.balance_transactions.index',compact('processed_balance_transactions','unprocessed_balance_transactions'));   //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-stripe-balance-transaction');
        // unused empty shell - records are imported from stripe payouts
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-stripe-balance-transaction');

        // unused empty shell - balance transactions are imported from stripe payouts
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($stripe_balance_transaction_id)
    {
        $this->authorize('show-stripe-balance-transaction');

        $balance_transaction = StripeBalanceTransaction::whereBalanceTransactionId($stripe_balance_transaction_id)->first();
        // dd($transaction);
        // $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        // $stripe_transaction = $stripe->balanceTransaction->retrieve($balance_transaction_id,[]);

        return view('stripe.balance_transactions.show',compact('balance_transaction'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-stripe-balance-transaction');

        $balance_transaction = StripeBalanceTransaction::findOrFail($id);
        
        
        $matching_contacts = $this->matched_contacts($balance_transaction);
        if (! array_key_exists($balance_transaction->contact_id,$matching_contacts) && isset($balance_transaction->contact_id)) {
            $matching_contacts[$balance_transaction->contact_id] = $balance_transaction->retreatant->full_name_with_city;
        }

        //dd($matching_contacts, $balance_transaction);

        return view('stripe.balance_transactions.edit', compact('balance_transaction', 'matching_contacts'));
    
        
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

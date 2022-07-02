<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStripeBalanceTransactionRequest;
use App\Models\StripeBalanceTransaction;
use App\Models\StripePayout;
use App\Traits\SquareSpaceTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Stripe\StripeClient;
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

        // TODO: determine type of transaction order, donation, manual

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
    public function update(UpdateStripeBalanceTransactionRequest $request, $id)
    {
        $this->authorize('update-stripe-balance-transaction');
        // TODO: figure out type of transaction (order, donation, manual, etc.)        
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
     * Import Stripe Balance Transactions for a given Stripe Payouts into stripe_balance_transaction table
     *
     * @return \Illuminate\Http\Response
     */
    public function import($payout_id)
    {
        $this->authorize('import-stripe-balance_transaction');
        // dd('Stripe Payout Import');
        $payout = StripePayout::findOrFail($payout_id);
        
        $stripe = new StripeClient(config('services.stripe.secret'));
        $balance_transactions = $stripe->balanceTransactions->all(
            ['payout' => $payout->payout_id,
            'type' => 'charge',
            'limit' => 100,
            ]
        );

        foreach ($balance_transactions->autoPagingIterator() as $balance_transaction) {
            //dd($balance_transaction->balance_transaction_id);
            $stripe_balance_transaction = StripeBalanceTransaction::firstOrNew([
                'balance_transaction_id' => $balance_transaction->id,
            ]);

            $charge = $stripe->charges->retrieve($balance_transaction->source,[]);
            //dd($charge);
            $customer = !is_null($charge->customer) ? $stripe->customers->retrieve($charge->customer) : NULL;
            $receipt_email = $charge->receipt_email;
            $customer_email = (isset($customer)) ? $customer->email : null;
            $description = $balance_transaction->description;
            $description_email = null;
            if ((strpos($description,'Charge for ')) === 0 || (strpos($description,'Donation by ')) === 0 ) {
                $description_pieces = explode(' ',$description);
                $description_email = array_pop($description_pieces);
                // dd($description_email);    
            }
            
            $stripe_balance_transaction->payout_id = $payout->id;
            $stripe_balance_transaction->customer_id  = optional($customer)->id;
            $stripe_balance_transaction->charge_id  = $balance_transaction->source;
            $stripe_balance_transaction->payout_date  = Carbon::parse($payout->arrival_date);
            $stripe_balance_transaction->description  = $balance_transaction->description;
            $stripe_balance_transaction->name  = $charge->billing_details->name;
            $stripe_balance_transaction->email  = (isset($description_email)) ? $description_email : $receipt_email;
            $stripe_balance_transaction->zip  = $charge->billing_details->address->postal_code;
            $stripe_balance_transaction->cc_last_4  = $charge->payment_method_details->card->last4;
            $stripe_balance_transaction->total_amount  = $balance_transaction->amount / 100; 
            $stripe_balance_transaction->fee_amount  = $balance_transaction->fee / 100;
            $stripe_balance_transaction->net_amount  = $balance_transaction->net /100;
            $stripe_balance_transaction->available_date  = Carbon::parse($balance_transaction->available_on);
            $stripe_balance_transaction->created_at  = Carbon::parse($balance_transaction->created);            
            $stripe_balance_transaction->type  = $balance_transaction->type;
            $stripe_balance_transaction->note  = null;
            $stripe_balance_transaction->phone  = null;
            // dd($stripe_balance_transaction);
            $stripe_balance_transaction->save();
        }

        return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'],$payout->payout_id);

    }

}

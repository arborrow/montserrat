<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStripeBalanceTransactionRequest;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\SquarespaceOrder;
use App\Models\SquarespaceContribution;
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

        $balance_transaction = StripeBalanceTransaction::whereBalanceTransactionId($stripe_balance_transaction_id)->with('payments')->first();
        // dd($balance_transaction);
        
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
        // dd($balance_transaction);
        if (!isset($balance_transaction->reconcile_date)) { // if the balance_transaction record has already been reconciled then do not allow to edit
            switch ($balance_transaction->transaction_type) {
                case 'Manual' :
                    $transaction_types = ($balance_transaction->transaction_type == 'Manual') ? explode(' + ',$balance_transaction->description) : null;
                    foreach ($transaction_types as $type) {
                        $type = config('polanco.stripe_balance_transaction_types.'.$type);
                    }
                    break;
                case 'Donation' :
                    $transaction_types = 'Donation';
                    $unprocessed_squarespace_contributions = SquarespaceContribution::whereNull('stripe_charge_id')->whereNotNull('donation_id')->get();
                    dd($unprocessed_squarespace_contributions);
                    break;
                case 'Invoice' :
                    $transaction_types = 'Invoice';
                    break;
                case 'Charge' :
                    $transaction_types = 'Retreat Funding';
                    $squarespace_order = SquarespaceOrder::whereStripeChargeId($balance_transaction->charge_id)->first();
                    $donation = Donation::findOrFail($squarespace_order->donation_id);
                    $payment = new Payment; 
                    $payment->donation_id = $donation->donation_id;
                    $payment->stripe_balance_transaction_id = $balance_transaction->id;
                    $payment->payment_amount = $balance_transaction->total_amount;
                    $payment->payment_date = $balance_transaction->payout_date;
                    $payment->payment_description = "Credit card";
                    $payment->ccnumber = $balance_transaction->cc_last_4;                    
                    
                    if ($squarespace_order->is_couple) {
                        $couple_donation = Donation::findOrFail($squarespace_order->couple_donation_id);
                        $couple_payment = new Payment;
                        $couple_payment->donation_id = $couple_donation->donation_id;
                        $couple_payment->stripe_balance_transaction_id = $balance_transaction->id;
                        $payment->payment_amount = $donation->donation_amount;
                        $couple_payment->payment_amount = $couple_donation->donation_amount;
                        $couple_payment->payment_date = $balance_transaction->payout_date;
                        $couple_payment->payment_description = "Credit card";
                        $couple_payment->ccnumber = $balance_transaction->cc_last_4;
                        $couple_payment->save();
                    }

                    $payment->save();
                    $balance_transaction->reconcile_date = now();
                    $balance_transaction->payment_id = $payment->payment_id;
                    $balance_transaction->contact_id = $payment->donation->contact->id;
                    $balance_transaction->save();
                    // dd($balance_transaction, $squarespace_order, $donation, $payment);
                    flash('Stripe Balance Transaction #: <a href="'.url('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id).'">'.$balance_transaction->id.'</a> processed successfully.')->success();

                    return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'],$balance_transaction->payout_id);
                    break;
            }
        } else {
            flash('Stripe Balance Transaction #: <a href="'.url('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id).'">'.$balance_transaction->id.'</a> has already been processed.')->warning();
            return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'],$balance_transaction->payout_id);
        }    

        
        
        $matching_contacts = $this->matched_contacts($balance_transaction);
        if (! array_key_exists($balance_transaction->contact_id,$matching_contacts) && isset($balance_transaction->contact_id)) {
            $matching_contacts[$balance_transaction->contact_id] = $balance_transaction->retreatant->full_name_with_city;
        }
        
        return view('stripe.balance_transactions.edit', compact('balance_transaction', 'matching_contacts','transaction_types'));
    
        
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
        // dd($request);
        return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'],$request->input('payout_id'));

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
        $stripe_balance_transactions = $stripe->balanceTransactions->all(
            ['payout' => $payout->payout_id,
            'type' => 'charge',
            'limit' => 100,
            ]
        );

        foreach ($stripe_balance_transactions->autoPagingIterator() as $stripe_balance_transaction) {
            //dd($balance_transaction->balance_transaction_id);
            $balance_transaction = StripeBalanceTransaction::firstOrNew([
                'balance_transaction_id' => $stripe_balance_transaction->id,
            ]);

            $stripe_charge = $stripe->charges->retrieve($stripe_balance_transaction->source,[]);

            $stripe_customer = !is_null($stripe_charge->customer) ? $stripe->customers->retrieve($stripe_charge->customer) : NULL;
            $receipt_email = $stripe_charge->receipt_email;
            $customer_email = (isset($stripe_customer)) ? $stripe_customer->email : null;
            $description = $stripe_balance_transaction->description;
            $description_email = null;
            if ((strpos($description,'Charge for ')) === 0 || (strpos($description,'Donation by ')) === 0 ) {
                $description_pieces = explode(' ',$description);
                $description_email = array_pop($description_pieces);
            }
            
            $balance_transaction->payout_id = $payout->payout_id;
            $balance_transaction->customer_id  = optional($stripe_customer)->id;
            $balance_transaction->charge_id  = $stripe_balance_transaction->source;
            $balance_transaction->payout_date  = $payout->arrival_date;
            $balance_transaction->description  = $stripe_balance_transaction->description;
            $balance_transaction->name  = $stripe_charge->billing_details->name;
            if (!isset($balance_transaction->name)) {
                //dd($stripe_balance_transaction, $stripe_charge, $stripe_customer, $balance_transaction->name);
            
                $balance_transaction->name  = $stripe_customer->name;
            }
            $balance_transaction->email  = (isset($description_email)) ? $description_email : $receipt_email;
            $balance_transaction->zip  = $stripe_charge->billing_details->address->postal_code;
            $balance_transaction->cc_last_4  = $stripe_charge->payment_method_details->card->last4;
            $balance_transaction->total_amount  = $stripe_balance_transaction->amount / 100; 
            $balance_transaction->fee_amount  = $stripe_balance_transaction->fee / 100;
            $balance_transaction->net_amount  = $stripe_balance_transaction->net /100;
            $balance_transaction->available_date  = Carbon::parse($stripe_balance_transaction->available_on);
            $balance_transaction->created_at  = Carbon::parse($stripe_balance_transaction->created);            
            $balance_transaction->type  = $stripe_balance_transaction->type;
            $balance_transaction->note  = null;
            $balance_transaction->phone  = null;

            switch ($balance_transaction->description) {
                case (strpos($balance_transaction->description,'Invoice ') === 0 || strpos($balance_transaction->description,'Subscription creation') === 0 ) :
                    $balance_transaction->transaction_type = 'Invoice';
                    break;
                case (strpos($balance_transaction->description,'Donation by ') === 0) :
                    $balance_transaction->transaction_type = 'Donation';
                    break;
                case (strpos($balance_transaction->description,'Charge for ') === 0) :
                    $balance_transaction->transaction_type = 'Charge';
                    break;
                default :
                    $balance_transaction->transaction_type = 'Manual';
                    break;
            }
            
            // dd($stripe_balance_transaction);
            $balance_transaction->save();
        }

        return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'],$payout->payout_id);

    }

}
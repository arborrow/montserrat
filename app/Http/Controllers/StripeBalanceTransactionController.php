<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateStripeBalanceTransactionRequest;
use App\Models\Contact;
use App\Models\Donation;
use App\Models\Payment;
use App\Models\Retreat;
use App\Models\SquarespaceContribution;
use App\Models\SquarespaceOrder;
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
    public function index(): View
    {
        $this->authorize('show-stripe-balance-transaction');

        $processed_balance_transactions = StripeBalanceTransaction::whereNotNull('reconcile_date')->orderBy('created_at')->paginate(25, ['*'], 'processed_balance_transactions');
        $unprocessed_balance_transactions = StripeBalanceTransaction::whereNull('reconcile_date')->orderByDesc('created_at')->paginate(25, ['*'], 'unprocessed_balance_transactions');

        return view('stripe.balance_transactions.index', compact('processed_balance_transactions', 'unprocessed_balance_transactions'));   //
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
    public function show($stripe_balance_transaction_id): View
    {
        $this->authorize('show-stripe-balance-transaction');

        $balance_transaction = StripeBalanceTransaction::whereBalanceTransactionId($stripe_balance_transaction_id)->with('payments')->first();
        // dd($balance_transaction);

        // $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        // $stripe_transaction = $stripe->balanceTransaction->retrieve($balance_transaction_id,[]);

        return view('stripe.balance_transactions.show', compact('balance_transaction'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_id(int $id): View
    {
        $this->authorize('show-stripe-balance-transaction');

        $balance_transaction = StripeBalanceTransaction::with('payments')->findOrFail($id);
        // dd($balance_transaction);

        // $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        // $stripe_transaction = $stripe->balanceTransaction->retrieve($balance_transaction_id,[]);

        return view('stripe.balance_transactions.show', compact('balance_transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $this->authorize('update-stripe-balance-transaction');
        $unprocessed_squarespace_contributions = collect();
        $donations = collect();
        // TODO: determine type of transaction order, donation, manual

        $balance_transaction = StripeBalanceTransaction::findOrFail($id);
        $retreats = null;
        // dd($balance_transaction);
        if (! isset($balance_transaction->reconcile_date)) { // if the balance_transaction record has already been reconciled then do not allow to edit
            switch ($balance_transaction->transaction_type) {
                case 'Manual':
                    $transaction_types = ($balance_transaction->transaction_type == 'Manual') ? explode(' + ', $balance_transaction->description) : null;
                    foreach ($transaction_types as $type) {
                        $type = config('polanco.stripe_balance_transaction_types.'.$type);
                    }

                    if (isset($balance_transaction->contact_id) && $balance_transaction->contact_id > 0) {
                        $retreats = $this->contact_retreats($balance_transaction->contact_id);
                    } else {
                        $retreats = $this->upcoming_retreats();
                    }
                    break;
                case 'Donation':
                    $transaction_types = 'Donation';
                    $unprocessed_squarespace_contributions = SquarespaceContribution::whereNull('stripe_charge_id')->whereNotNull('donation_id')->get()->pluck('FullDescription', 'id');
                    //dd($unprocessed_squarespace_contributions);
                    break;
                case 'Invoice':
                    $transaction_types = 'Invoice';
                    $invoice_number = substr($balance_transaction->description, strpos($balance_transaction->description, ' ') + 1, (strpos($balance_transaction->description, '-') - strpos($balance_transaction->description, ' ') - 1));
                    $donation = Donation::whereStripeInvoice($invoice_number)->first();
                    $contact_id = (isset($donation)) ? $donation->contact_id : $balance_transaction->contact_id;

                    if (isset($donation)) {
                        $payment = new Payment;
                        $payment->donation_id = $donation->donation_id;
                        $payment->payment_amount = $balance_transaction->total_amount;
                        $payment->payment_date = $balance_transaction->payout_date;
                        $payment->payment_description = 'Credit card';
                        $payment->ccnumber = $balance_transaction->cc_last_4;
                        $payment->stripe_balance_transaction_id = $balance_transaction->id;
                        $payment->save();

                        if ($donation->donation_amount < $donation->payments_paid) { // the new payment has increased the amount of the donation
                            flash('Overpayment? Pledged amount for Donation #: <a href="'.url('/donation/'.$donation->donation_id).'">'.$donation->donation_id.'</a> has been increased from $'
                            .number_format($donation->donation_amount, 2).' to $'
                            .number_format($donation->payments_paid, 2).'.')->warning()->important();

                            $donation->donation_amount = $donation->payments_paid;
                            $donation->save();
                        }

                        $balance_transaction->contact_id = $donation->contact_id; // delay saving contact_id to avoid flash on first retrieval of contact info
                        $balance_transaction->reconcile_date = now();
                        $balance_transaction->save();

                        flash('Stripe Balance Transaction #'.$balance_transaction->id.' has been successfully processed.')->success();

                        return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $balance_transaction->payout_id);
                    } else {
                        if ($balance_transaction->contact_id > 0) {
                            $donations = Donation::whereContactId($balance_transaction->contact_id)->orderBy('donation_date', 'DESC')->get()->pluck('donation_summary', 'donation_id');
                        }
                        $donations[0] = 'Create New Donation';
                    }
                    break;
                case 'Charge':
                    $transaction_types = 'Retreat Funding';
                    $squarespace_order = SquarespaceOrder::whereStripeChargeId($balance_transaction->charge_id)->first();
                    $donation = Donation::findOrFail($squarespace_order->donation_id);
                    $payment = new Payment;
                    $payment->donation_id = $donation->donation_id;
                    $payment->stripe_balance_transaction_id = $balance_transaction->id;
                    $payment->payment_amount = $balance_transaction->total_amount;
                    $payment->payment_date = $balance_transaction->payout_date;
                    $payment->payment_description = 'Credit card';
                    $payment->ccnumber = $balance_transaction->cc_last_4;

                    // make sure the couple_donation_id is set - otherwise it is likely a gift certificate
                    if ($squarespace_order->is_couple && isset($squarespace_order->couple_donation_id)) {
                        $couple_donation = Donation::findOrFail($squarespace_order->couple_donation_id);
                        $couple_payment = new Payment;
                        $couple_payment->donation_id = $couple_donation->donation_id;
                        $couple_payment->stripe_balance_transaction_id = $balance_transaction->id;
                        $payment->payment_amount = $donation->donation_amount;
                        $couple_payment->payment_amount = $couple_donation->donation_amount;
                        $couple_payment->payment_date = $balance_transaction->payout_date;
                        $couple_payment->payment_description = 'Credit card';
                        $couple_payment->ccnumber = $balance_transaction->cc_last_4;
                        $couple_payment->save();
                    }

                    $payment->save();
                    $balance_transaction->reconcile_date = now();
                    $balance_transaction->contact_id = $payment->donation->contact->id;
                    $balance_transaction->save();
                    // dd($balance_transaction, $squarespace_order, $donation, $payment);
                    flash('Stripe Balance Transaction #: <a href="'.url('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id).'">'.$balance_transaction->id.'</a> processed successfully.')->success();

                    return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $balance_transaction->payout_id);
                    break;
                case 'Refund':

                    // get the charge balance transaction for this refund
                    // get the payments associated with the charge balance transaction
                    // refund each payment

                    $charge = StripeBalanceTransaction::whereChargeId($balance_transaction->charge_id)->whereType('charge')->first();
                    $charge_payments = Payment::whereStripeBalanceTransactionId($charge->id)->get();

                    if ($charge_payments->count() > 1) {
                        flash('Refund for Stripe Balance Transaction #: <a href="'.url('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id).'">'.$balance_transaction->id.'</a> associated with more than one payment. Please process the refund manually.')->warning()->important();

                        return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $balance_transaction->payout_id);
                    } else {
                        $charge_payment = $charge_payments[0];
                        $donation = Donation::findOrFail($charge_payment->donation_id);

                        $refund = new Payment;
                        $refund->donation_id = $charge_payment->donation_id;
                        $refund->payment_amount = $balance_transaction->total_amount;
                        $refund->payment_date = $balance_transaction->payout_date;
                        $refund->payment_description = 'Credit card';
                        $refund->ccnumber = $balance_transaction->cc_last_4;
                        $refund->stripe_balance_transaction_id = $balance_transaction->id;
                        $refund->save();

                        $donation->donation_amount = $donation->donation_amount + $refund->payment_amount;
                        $donation->save();

                        $balance_transaction->reconcile_date = now();
                        $balance_transaction->contact_id = $refund->donation->contact->id;
                        $balance_transaction->save();

                        flash('Refund for Stripe Balance Transaction #: <a href="'.url('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id).'">'.$balance_transaction->id.'</a> successfully processed.')->success();
                    }

                    return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $balance_transaction->payout_id);
                    break;
            }
        } else {
            flash('Stripe Balance Transaction #: <a href="'.url('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id).'">'.$balance_transaction->id.'</a> has already been processed.')->warning();

            return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $balance_transaction->payout_id);
        }

        $matching_contacts = $this->matched_contacts($balance_transaction);
        if (! array_key_exists($balance_transaction->contact_id, $matching_contacts) && isset($balance_transaction->contact_id)) {
            $matching_contacts[$balance_transaction->contact_id] = $balance_transaction->retreatant->full_name_with_city;
        }

        return view('stripe.balance_transactions.edit', compact('balance_transaction', 'matching_contacts', 'transaction_types', 'unprocessed_squarespace_contributions', 'retreats', 'donations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStripeBalanceTransactionRequest $request, int $id)
    {
        $this->authorize('update-stripe-balance-transaction');

        $balance_transaction = StripeBalanceTransaction::findOrFail($id);

        switch ($balance_transaction->transaction_type) {
            case 'Donation':
                $contribution_id = ($request->filled('contribution_id')) ? $request->input('contribution_id') : null;
                $squarespace_contribution = SquarespaceContribution::findOrFail($contribution_id);
                $donation = Donation::findOrFail($squarespace_contribution->donation_id);

                $squarespace_contribution->stripe_charge_id = $balance_transaction->charge_id;
                $squarespace_contribution->save();
                $payment = new Payment;
                $payment->donation_id = $donation->donation_id;
                $payment->stripe_balance_transaction_id = $balance_transaction->id;
                $payment->payment_amount = $balance_transaction->total_amount;
                $payment->payment_date = $balance_transaction->payout_date;
                $payment->payment_description = 'Credit card';
                $payment->ccnumber = $balance_transaction->cc_last_4;
                $payment->save();

                $balance_transaction->reconcile_date = now();
                $balance_transaction->save();

                flash('Stripe Balance Transaction #: <a href="'.url('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id).'">'.$balance_transaction->id.'</a> processed successfully.')->success();

                return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $balance_transaction->payout_id);
                break;

            case 'Manual':
                $contact_id = ($request->filled('contact_id')) ? $request->input('contact_id') : null;
                $proceed = isset($balance_transaction->contact_id);
                $balance_transaction->contact_id = $contact_id;
                $balance_transaction->save();

                if ($balance_transaction->contact_id == 0) {
                    // Create a new contact
                    $contact = new Contact;
                    $contact->contact_type = config('polanco.contact_type.individual');
                    $contact->subcontact_type = 0;

                    $names = explode(' ', $balance_transaction->name);
                    $number_of_names = count($names);
                    $last_name = $names[$number_of_names - 1];
                    $middle_name = ($number_of_names > 2) ? implode(' ', array_slice($names, 1, $number_of_names - 2)) : null;
                    $first_name = $names[0];

                    $contact->first_name = $first_name;
                    $contact->middle_name = $middle_name;
                    $contact->last_name = $last_name;
                    $contact->sort_name = $last_name.', '.$first_name;
                    $contact->display_name = $balance_transaction->name;
                    $contact->save();

                    $contact_id = $contact->id;
                    $balance_transaction->contact_id = $contact->id;
                    $balance_transaction->save();

                    return Redirect::action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id);
                } else {
                    $contact = Contact::findOrFail($contact_id);
                    $balance_transaction->contact_id = $contact->id;
                    $balance_transaction->save();

                    if (! $proceed) {
                        return Redirect::action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id);
                    }
                    //dd(($couple_contact_id == 0 && !isset($order->couple_contact_id)),$order->is_couple, $couple_contact_id, !isset($order->couple_contact_id), $contact, $request);
                }

                // validation - ensure the total of the distribution amounts is equal to the total amount of the Stripe balance transaction
                $distribution = [];
                $transaction_types = ($balance_transaction->transaction_type == 'Manual') ? explode(' + ', $balance_transaction->description) : null;
                foreach ($transaction_types as $type) {
                    $camel_type = str_replace(' ', '_', strtolower($type));
                    $distribution[$camel_type] = ($request->filled($camel_type)) ? $request->input($camel_type) : 0;
                }
                $total_distributions = array_sum($distribution);

                if ($balance_transaction->total_amount != $total_distributions) { // total of distributions does not equal total amount - flash warning and return
                    flash('Review and correct the distributions. The total of distributions ($'.number_format($total_distributions, 2).') does not equal the Total Amount ($'.number_format($balance_transaction->total_amount, 2).') of this Stripe Balance Transaction.')->error()->important();

                    return Redirect::action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id);
                }

                // check to see if this Stripe balance transaction is associate with a retreat/event
                $event_id = ($request->filled('event_id')) ? $request->input('event_id') : null;
                $event = ($event_id > 0) ? Retreat::findOrFail($event_id) : null;

                // create donations and payments and mark balance transaction as reconciled
                foreach ($transaction_types as $type) {
                    if ($type == 'Donacion de Retiro' || $type == 'Retreat Offering') {
                        $deposit_donation = Donation::whereEventId($event_id)->whereContactId($contact_id)->whereDonationDescription('Retreat Deposits')->get();
                        if (isset($deposit_donation) && $deposit_donation->count() == 1) {
                            $camel_type = str_replace(' ', '_', strtolower($type));
                            $donation = $deposit_donation[0];
                            $donation->donation_date = (isset($event->start_date)) ? $event->start_date : $balance_transaction->payout_date;
                            $donation->donation_description = config('polanco.stripe_balance_transaction_types.'.$type);
                            $donation->donation_amount += $distribution[$camel_type];
                            $donation->save();
                        }
                    }

                    if (! isset($donation)) { // above try to find related deposit otherwise create new donation
                        $camel_type = str_replace(' ', '_', strtolower($type));
                        $donation = new Donation;
                        $donation->donation_date = (isset($event->start_date)) ? $event->start_date : $balance_transaction->payout_date;
                        $donation->donation_description = config('polanco.stripe_balance_transaction_types.'.$type);
                        $donation->contact_id = $balance_transaction->contact_id;
                        $donation->event_id = (isset($event->id)) ? $event->id : null;
                        $donation->donation_amount = $distribution[$camel_type];
                        // dd($transaction_types, $type, $distribution, $donation);
                        $donation->save();
                    }

                    $payment = new Payment;
                    $payment->donation_id = $donation->donation_id;
                    $payment->payment_amount = $distribution[$camel_type];
                    $payment->payment_date = $balance_transaction->payout_date;
                    $payment->payment_description = 'Credit card';
                    $payment->ccnumber = $balance_transaction->cc_last_4;
                    $payment->stripe_balance_transaction_id = $balance_transaction->id;
                    $payment->save();

                    $donation = null; // reset $donation for each iteration of foreach loop
                }

                $balance_transaction->reconcile_date = now();
                $balance_transaction->save();

                flash('Stripe Balance Transaction #'.$balance_transaction->id.' has been successfully processed.')->success();
                break;
            case 'Invoice':
                // process contact_id
                // $contact_id = ($request->filled('contact_id')) ? $request->input('contact_id') : null;
                $invoice_number = substr($balance_transaction->description, strpos($balance_transaction->description, ' ') + 1, (strpos($balance_transaction->description, '-') - strpos($balance_transaction->description, ' ') - 1));
                $donation = Donation::whereStripeInvoice($invoice_number)->first();
                $contact_id = (isset($donation)) ? $donation->contact_id : $request->input('contact_id');
                if (! isset($contact_id) || $contact_id == 0) {
                    // Create a new contact - an invoice assumes that the contact and donation already exist

                    /*
                    $contact = new Contact;
                    $contact->contact_type = config('polanco.contact_type.individual');
                    $contact->subcontact_type = 0;

                    $names = explode(' ', $balance_transaction->name);
                    $number_of_names= count($names);
                    $last_name = $names[$number_of_names-1];
                    $middle_name = ($number_of_names > 2) ? implode(' ',array_slice($names,1,$number_of_names-2)) : null;
                    $first_name = $names[0];

                    $contact->first_name = $first_name;
                    $contact->middle_name = $middle_name;
                    $contact->last_name = $last_name;
                    $contact->sort_name = $last_name . ', ' . $first_name;
                    $contact->display_name = $balance_transaction->name;
                    $contact->save();

                    $contact_id = $contact->id;
                    $balance_transaction->contact_id = $contact->id;
                    $balance_transaction->save();
                    */
                    flash('Select the appropriate Donor from the Donor dropdown list. If a Donor does not exist, consider manually creating one.')->error()->important();

                    return Redirect::action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id);
                } else {
                    $contact = Contact::findOrFail($contact_id);
                }

                $donation_id = (isset($donation)) ? $donation->donation_id : $request->input('donation_id');
                if ($donation_id == 0 && $balance_transaction->contact_id > 0) { // normally would attempt to create a new Donation
                    flash('Select the appropriate Donation from the Donation dropdown list. If a donation does not exist, consider manually creating one.')->error()->important();

                    return Redirect::action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id);
                }
                // dd($contact_id, $donation_id, $balance_transaction); // 40, 0,
                if ($donation_id > 0 && $balance_transaction->contact_id > 0) { // we have contact_id and donation_id
                    $donation = Donation::findOrFail($donation_id);

                    // if the invoice number has not been saved to this donation go ahead and do that now
                    if (! isset($donation->stripe_invoice)) {
                        $donation->stripe_invoice = $invoice_number;
                        $donation->save();
                    }

                    // add invoice payment to the donation
                    $payment = new Payment;
                    $payment->donation_id = $donation->donation_id;
                    $payment->payment_amount = $balance_transaction->total_amount;
                    $payment->payment_date = $balance_transaction->payout_date;
                    $payment->payment_description = 'Credit card';
                    $payment->ccnumber = $balance_transaction->cc_last_4;
                    $payment->stripe_balance_transaction_id = $balance_transaction->id;
                    $payment->save();

                    if ($donation->donation_amount < $donation->payments_paid) { // the new payment has increased the amount of the donation
                        flash('Overpayment? Pledged amount for Donation #: <a href="'.url('/donation/'.$donation->donation_id).'">'.$donation->donation_id.'</a> has been increased from $'
                        .number_format($donation->donation_amount, 2).' to $'
                        .number_format($donation->payments_paid, 2).'.')->warning()->important();

                        $donation->donation_amount = $donation->payments_paid;
                        $donation->save();
                    }

                    $balance_transaction->contact_id = $contact->id; // delay saving contact_id to avoid flash on first retrieval of contact info
                    $balance_transaction->reconcile_date = now();
                    $balance_transaction->save();

                    flash('Stripe Balance Transaction #'.$balance_transaction->id.' has been successfully processed.')->success();

                    return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $request->input('payout_id'));
                } else {
                    $balance_transaction->contact_id = $contact->id; // delay saving contact_id to avoid flash on first retrieval of contact info
                    $balance_transaction->save();

                    return Redirect::action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id);
                }
                break;
        }

        return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $request->input('payout_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
    }

    /**
     * Import Stripe Balance Transactions for a given Stripe Payouts into stripe_balance_transaction table
     *
     * @return \Illuminate\Http\Response
     */
    public function import($payout_id): RedirectResponse
    {
        $this->authorize('import-stripe-balance_transaction');
        $payout = StripePayout::findOrFail($payout_id);

        $stripe = new StripeClient(config('services.stripe.secret'));

        $stripe_balance_transactions = $stripe->balanceTransactions->all(
            ['payout' => $payout->payout_id,
                'type' => 'charge',
                'limit' => 100,
            ]
        );

        $stripe_refunds = $stripe->balanceTransactions->all(
            ['payout' => $payout->payout_id,
                'type' => 'refund',
                'limit' => 100,
            ]
        );

        $this->store_balance_transactions($payout, $stripe_balance_transactions);
        $this->store_balance_transactions($payout, $stripe_refunds);

        return Redirect::action([\App\Http\Controllers\StripePayoutController::class, 'show'], $payout->payout_id);
    }

    public function store_balance_transactions($payout, $stripe_balance_transactions)
    {
        $this->authorize('import-stripe-balance_transaction');

        $stripe = new StripeClient(config('services.stripe.secret'));

        foreach ($stripe_balance_transactions->autoPagingIterator() as $stripe_balance_transaction) {
            $balance_transaction = StripeBalanceTransaction::firstOrNew([
                'balance_transaction_id' => $stripe_balance_transaction->id,
            ]);

            $stripe_charge = $stripe->charges->retrieve($stripe_balance_transaction->source, []);

            $stripe_customer = ! is_null($stripe_charge->customer) ? $stripe->customers->retrieve($stripe_charge->customer) : null;
            $receipt_email = $stripe_charge->receipt_email;
            $customer_email = (isset($stripe_customer)) ? $stripe_customer->email : null;
            $description = $stripe_balance_transaction->description;
            $description_email = null;
            if ((strpos($description, 'Charge for ')) === 0 || (strpos($description, 'Donation by ')) === 0) {
                $description_pieces = explode(' ', $description);
                $description_email = array_pop($description_pieces);
            }

            $balance_transaction->payout_id = $payout->payout_id;
            $balance_transaction->customer_id = $stripe_customer?->id;
            $balance_transaction->charge_id = $stripe_balance_transaction->source;
            $balance_transaction->payout_date = $payout->arrival_date;
            $balance_transaction->description = $stripe_balance_transaction->description;
            $balance_transaction->name = $stripe_charge->billing_details->name;

            if (! isset($balance_transaction->name)) {
                if (isset($stripe_customer->name)) {
                    $balance_transaction->name = $stripe_customer->name;
                } else {
                    // unable to find a name but do not throw error; instead catch with database health check for anonymous stripe balance transactions
                }
            }

            $balance_transaction->email = (isset($description_email)) ? $description_email : $receipt_email;
            $balance_transaction->zip = $stripe_charge->billing_details->address->postal_code;
            $balance_transaction->cc_last_4 = $stripe_charge->payment_method_details->card->last4;
            $balance_transaction->total_amount = $stripe_balance_transaction->amount / 100;
            $balance_transaction->fee_amount = $stripe_balance_transaction->fee / 100;
            $balance_transaction->net_amount = $stripe_balance_transaction->net / 100;
            $balance_transaction->available_date = Carbon::parse($stripe_balance_transaction->available_on);
            $balance_transaction->created_at = Carbon::parse($stripe_balance_transaction->created);
            $balance_transaction->type = $stripe_balance_transaction->type;
            $balance_transaction->note = null;
            $balance_transaction->phone = null;

            switch ($balance_transaction->description) {
                case strpos($balance_transaction->description, 'Invoice ') === 0 || strpos($balance_transaction->description, 'Subscription creation') === 0:
                    $balance_transaction->transaction_type = 'Invoice';
                    break;
                case strpos($balance_transaction->description, 'Donation by ') === 0:
                    $balance_transaction->transaction_type = 'Donation';
                    break;
                case strpos($balance_transaction->description, 'REFUND') === 0:
                    $balance_transaction->transaction_type = 'Refund';
                    break;
                case strpos($balance_transaction->description, 'Charge for ') === 0:
                    $balance_transaction->transaction_type = 'Charge';
                    break;
                default:
                    $balance_transaction->transaction_type = 'Manual';
                    break;
            }

            // dd($stripe_balance_transaction);
            $balance_transaction->save();
        }
    }

    /**
     * Reset to re-select the donor for a Stripe Balance Transaction.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset(int $id): RedirectResponse
    {
        $this->authorize('update-stripe-balance-transaction');

        $balance_transaction = StripeBalanceTransaction::findOrFail($id);
        $balance_transaction->contact_id = null;
        $balance_transaction->save();

        return Redirect::action([self::class, 'edit'], ['balance_transaction' => $id]);
    }
}

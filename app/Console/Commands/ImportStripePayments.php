<?php

namespace App\Console\Commands;

use App\Models\StripeBalanceTransaction;
use App\Models\StripePayout;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\StripeClient;

class ImportStripePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:stripe_payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Stripe Payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
	// $process_date = Carbon::parse("2026-08-10");
	// dd($process_date);    
	$payouts = StripePayout::whereYear('date', 2024)->get();	
	$stripe = new StripeClient(config('services.stripe.secret'));
        //$payouts = $stripe->payouts->all(['arrival_date' => ['gte' => $process_date->timestamp]]);
	foreach ($payouts as $payout) {
		echo 'Processing for '.$payout->arrival_date;

            $fees = 0; // initialize
    
            $stripe_balance_transactions = $stripe->balanceTransactions->all(
                ['payout' => $payout->payout_id,
                    'type' => 'payment',
                    'limit' => 100,
                ]
            );

            foreach ($stripe_balance_transactions->autoPagingIterator() as $stripe_balance_transaction) {
		    // dd($balance_transaction->balance_transaction_id);
		    echo 'Processing SBT: '.$stripe_balance_transaction->id;
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
                $balance_transaction->cc_last_4 = 'Payment';
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
                    case strpos($balance_transaction->description, 'Charge for ') === 0:
                        $balance_transaction->transaction_type = 'Charge';
                        break;
                    default:
                        $balance_transaction->transaction_type = 'Manual';
                        break;
                }

                $balance_transaction->save();
            }
        }
    }
}

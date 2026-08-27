@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                            Stripe Payout # {{$payout->id}} details
                    </h2>
                </span>
            </div>

            <div class='row'>
                <div class='col-md-4'>
                    <strong>Payout ID: </strong>{{$payout->payout_id}}
                    <br /><strong>Date: </strong>{{$payout->date->format('m-d-Y')}}
		    <br /><strong>Amount: </strong> 
			<a href = "{{ URL('report/finance/cc_deposit/'.$payout->date->format('Ymd'))}}">
                            ${{ number_format($payout->amount,2) }}
                        </a> 
			@if ($payout->amount == $payout->credit_card_total)
			(Reconciled)
			@else 
			(Unreconciled: ${{number_format($payout->credit_card_total,2)}}; Diff.: ${{number_format($payout->amount - $payout->credit_card_total,2)}})
			@endIf


		    <br /><strong>Charge Fees: </strong>
   			@if (isset($payout->fee_payment_id))
                            <a href = "{{ URL('/payment/'.$payout->fee_payment_id)}}">
				${{ number_format($payout->total_fee_amount,2) }} 
			    </a>
                        @else
                            ${{ number_format($payout->total_fee_amount, 2) }}
                        @endIf

		    <br /><strong>Stripe Fees: </strong>
			@if (isset($payout->stripe_fee_payment_id))
                            <a href = "{{ URL('/payment/'.$payout->stripe_fee_payment_id)}}">
				${{ number_format($payout->stripe_fee_amount,2) }} 
			    </a>
                        @else
                            ${{ number_format($payout->stripe_fee_amount, 2) }}
                        @endIf

<!-- used for debugging -->
<!-- <br />SBT Count: {{$stripe_balance_transactions->count()}}, Refunds Count: {{$refunds->count()}}, Fees Count: {{$stripe_fees->count()}}, PBT Count: {{$balance_transactions->count()}}, Transactions Count: {{$transactions->count()}}
-->
                </div>
	    </div> 

                <table class="table table-bordered table-striped table-hover">
                    <caption>
                        <h2>
                            Imported Stripe Balance Transactions ({{ $balance_transactions->count() }})
                        </h2>
                    </caption>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Reconciled</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($balance_transactions as $balance_transaction)
                        @if ($balance_transaction->transaction_type == 'Refund')
                            <tr class="bg-warning">
                        @else
                            <tr>
                        @endIf
                            <td><a href="{{URL('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id)}}">{{ $balance_transaction->description }}</a></td>
                            <td>{{ $balance_transaction->name }}</td>
                            <td style='text-align: right'>${{ number_format($balance_transaction->total_amount,2) }}</td>
                            <td>
                                @if (isset($balance_transaction->reconcile_date))
                                    {{ \Carbon\Carbon::parse($balance_transaction->reconcile_date)->format('m-d-Y') }}
                                @else
                                    @switch ($balance_transaction->transaction_type)
                                        @case('Charge')
                                            {{ html()->a(url(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id)), 'Create Payment for Order #' . $balance_transaction->squarespace_order?->order_number)->class('btn btn-primary') }}
                                            @break
                                        @case('Donation')
                                            {{ html()->a(url(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id)), 'Create Payment for Donation' . $balance_transaction->squarespace_order?->order_number)->class('btn btn-primary') }}
                                            @break                                    
                                        @case('Invoice')
                                            {{ html()->a(url(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id)), 'Create Payment for ' . $balance_transaction->description)->class('btn btn-primary') }}
                                            @break                                    
                                        @case('Refund')
                                            {{ html()->a(url(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id)), 'Create Refund Credit Payment')->class('btn btn-primary') }}
                                            @break                                    
                                        @default
                                            {{ html()->a(url(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'], $balance_transaction->id)), 'Process Balance Transaction')->class('btn btn-primary') }}
                                            @break
                                    @endswitch
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
<hr />

		<table class="table table-bordered table-striped table-hover">
                    <caption>
                        <h2>Balance Transactions from Stripe API
<!-- {{ html()->a(url(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'import'], $payout->id)), 'Import ' . $stripe_balance_transactions->count() . ' Stripe Balance Transactions')->class('btn btn-secondary') }} -->
	 	      </h2>
                    </caption>
                    <thead>
                        <tr>
			    <th>Type</th>
			    <th>Description</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Source</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($stripe_balance_transactions as $stripe_balance_transaction)
			<tr>
			    <td>{{ $stripe_balance_transaction->type }} </td>
                            <td>{{ $stripe_balance_transaction->description }}</td>
                            <td>${{ number_format($stripe_balance_transaction->amount/100,2) }}</td>
                            <td>${{ number_format($stripe_balance_transaction->fee/100,2) }}</td>
                            <td><a href="{{ URL('stripe/'.$stripe_balance_transaction->type.'/'. $stripe_balance_transaction->source) }}">{{ $stripe_balance_transaction->source }}</a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
	      
    
        </div>
    </div>
</section>
@stop

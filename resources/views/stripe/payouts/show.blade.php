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
                    <br /><strong>Amount: </strong>${{ $payout->amount }}
                    <br /><strong>Total Fees: </strong>${{ number_format($payout->total_fee_amount,2)  }}
                </div>
            </div>
            @if ($stripe_balance_transactions->count() + $refunds->count() > $balance_transactions->count())
                <table class="table table-bordered table-striped table-hover">
                    <caption>
                        <h2>
                            {!! Html::link(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'import'],$payout->id),'Import ' . $stripe_balance_transactions->count() . ' Stripe Balance Transactions',array('class' => 'btn btn-secondary'))!!}
                        </h2>
                    </caption>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Source</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($refunds as $refund)
                        <tr class="bg-warning">
                            <td>{{ $refund->description }}</td>
                            <td>${{ number_format($refund->amount/100,2) }}</td>
                            <td></td>
                            <td><a href="{{ URL('stripe/charge/'.$refund->source) }}">{{ $refund->source }}</a></td>
                        </tr>
                        @endforeach


                        @foreach ($stripe_balance_transactions as $stripe_balance_transaction)
                        <tr>
                            <td>{{ $stripe_balance_transaction->description }}</td>
                            <td>${{ number_format($stripe_balance_transaction->amount/100,2) }}</td>
                            <td>${{ number_format($stripe_balance_transaction->fee/100,2) }}</td>
                            <td><a href="{{ URL('stripe/'.$stripe_balance_transaction->type.'/'. $stripe_balance_transaction->source) }}">{{ $stripe_balance_transaction->source }}</a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            @else                
                <table class="table table-bordered table-striped table-hover">
                    <caption>
                        <h2>
                            Balance Transactions ({{ $balance_transactions->count() }})
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
                                            {{ Html::link(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'],$balance_transaction->id),'Create Payment for Order #'.optional($balance_transaction->squarespace_order)->order_number,array('class' => 'btn btn-primary')) }}
                                            @break
                                        @case('Donation')
                                            {{ Html::link(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'],$balance_transaction->id),'Create Payment for Donation'.optional($balance_transaction->squarespace_order)->order_number,array('class' => 'btn btn-primary')) }}
                                            @break                                    
                                        @case('Invoice')
                                            {{ Html::link(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'],$balance_transaction->id),'Create Payment for '.$balance_transaction->description,array('class' => 'btn btn-primary')) }}
                                            @break                                    
                                        @case('Refund')
                                            {{ Html::link(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'],$balance_transaction->id),'Create Refund Credit Payment',array('class' => 'btn btn-primary')) }}
                                            @break                                    
                                        @default
                                            {{ Html::link(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'],$balance_transaction->id),'Process Balance Transaction',array('class' => 'btn btn-primary')) }}
                                            @break
                                    @endswitch
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            @endIf

        </div>
    </div>
</section>
@stop

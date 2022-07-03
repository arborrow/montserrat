@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                            Stripe Payout details
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
            @if ($stripe_balance_transactions->count() > $balance_transactions->count() )
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
                            <th>Amount</th>
                            <th>Fee</th>
                            <th>Created</th>
                            <th>Reconciled</th>
                            <th>Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balance_transactions as $balance_transaction)
                        <tr>
                            <td><a href="{{URL('/stripe/balance_transaction/'.$balance_transaction->balance_transaction_id)}}">{{ $balance_transaction->description }}</a></td>
                            <td>${{ number_format($balance_transaction->total_amount,2) }}</td>
                            <td>${{ number_format($balance_transaction->fee_amount,2) }}</td>
                            <td>{{ (isset($payout->created)) ? \Carbon\Carbon::parse($payout->created)->format('m-d-Y') : 'N/A' }}</td>
                            <td>{{ (isset($balance_transaction->reconcile_date)) ? 
                                    \Carbon\Carbon::parse($balance_transaction->reconcile_date)->format('m-d-Y') 
                                    : Html::link(action([\App\Http\Controllers\StripeBalanceTransactionController::class, 'edit'],$balance_transaction->id),'Process Balanace Transaction',array('class' => 'btn btn-primary'))

                                }}
                            </td>
                            <td><a href="{{ URL('stripe/charge/'. $balance_transaction->charge_id) }}">{{ $balance_transaction->charge_id }}</a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            @endIf

        </div>
    </div>
</section>
@stop

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
                    <strong>Payout ID: </strong>{{$stripe_payout->payout_id}}
                    <br /><strong>Date: </strong>{{$stripe_payout->date}}
                    <br /><strong>Amount: </strong>${{ $stripe_payout->amount }}
                    <br /><strong>Total Fees: </strong>${{ number_format($stripe_payout->total_fee_amount,2)  }}

                </div>
            </div>

            @if ($stripe_transactions->count() > $balance_transactions->count() )
                <table class="table table-bordered table-striped table-hover">
                    <caption>
                        <h2>
                            {!! Html::link(action([\App\Http\Controllers\StripePayoutController::class, 'import_balance_transactions'],$stripe_payout->id),'Import ' . $stripe_transactions->count() . ' Stripe Balance Transactions',array('class' => 'btn btn-secondary'))!!}
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
                        @foreach ($stripe_transactions as $transaction)
                        <tr>
                            <td><a href="{{URL('/stripe/balance_transaction/'.$transaction->id)}}">{{ $transaction->description }}</a></td>
                            <td>${{ number_format($transaction->amount/100,2) }}</td>
                            <td>${{ number_format($transaction->fee/100,2) }}</td>
                            <td>{{ (isset($payout->created)) ? \Carbon\Carbon::parse($payout->created)->format('m-d-Y') : 'N/A' }}</td>
                            <td>{{ (isset($payout->reconciled)) ? \Carbon\Carbon::parse($payout->reconciled)->format('m-d-Y') : 'Not yet' }}</td>
                            <td><a href="{{ URL('stripe/'.$transaction->type.'/'. $transaction->source) }}">{{ $transaction->source }}</a></td>
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
                        @foreach ($balance_transactions as $transaction)
                        <tr>
                            <td><a href="{{URL('/stripe/balance_transaction/'.$transaction->id.'/edit')}}">{{ $transaction->description }}</a></td>
                            <td>${{ number_format($transaction->total_amount/100,2) }}</td>
                            <td>${{ number_format($transaction->fee_amount/100,2) }}</td>
                            <td>{{ (isset($payout->created)) ? \Carbon\Carbon::parse($payout->created)->format('m-d-Y') : 'N/A' }}</td>
                            <td>{{ (isset($transaction->reconcile_date)) ? \Carbon\Carbon::parse($transaction->reconcile_date)->format('m-d-Y') : 'Not yet' }}</td>
                            <td><a href="{{ URL('stripe/charge/'. $transaction->charge_id) }}">{{ $transaction->charge_id }}</a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            @endIf

        </div>
    </div>
</section>
@stop

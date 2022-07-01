@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>
                    <h2>
                            Payout details
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

            <table class="table table-bordered table-striped table-hover">
                <caption>
                    <h2>
                        @if ($stripe_transactions->count() > $balance_transactions->count() )
                            {!! Html::link(action([\App\Http\Controllers\StripePayoutController::class, 'import_balance_transactions'],$stripe_payout->id),'Import ' . $stripe_transactions->count() . ' Stripe Balance Transactions',array('class' => 'btn btn-secondary'))!!}
                        @else
                            Balance Transactions ({{ $balance_transactions->count() }})
                        @endIf
                    </h2>
                </caption>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>Created</th>
                        <th>Source</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stripe_transactions as $transaction)
                    <tr>
                        <td><a href="{{URL('/stripe/balance_transaction/'.$transaction->id)}}">{{ $transaction->description }}</a></td>
                        <td>${{ number_format($transaction->amount/100,2) }}</td>
                        <td>${{ number_format($transaction->fee/100,2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($payout->created) }}</td>
                        <td><a href="{{ URL('stripe/'.$transaction->type.'/'. $transaction->source) }}">{{ $transaction->source }}</a></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
</section>
@stop

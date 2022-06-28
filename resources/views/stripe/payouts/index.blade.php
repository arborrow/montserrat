@extends('template')
@section('content')
    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Stripe Payouts</span>
                    </h1>
                    <span>{{ $payouts->links() }}</span>
                </div>
                {!! Html::link(action([\App\Http\Controllers\StripePayoutController::class, 'import']),'Import New Stripe Payouts',array('class' => 'btn btn-secondary'))!!}

                <table class="table table-bordered table-striped table-hover"><caption><h2>Stripe Payouts ({{ $payouts->total() }})</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class='text-right'>Amount</th>
                            <th class='text-right'>Fees</th>
                            <th class='text-right'>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($payouts as $payout)
                        <tr>
                            <td>
                                <a href="{{ URL('stripe/payout/' . $payout->payout_id) }} ">{{ $payout->date->format('M d, Y') }}</a>
                            </td>
                            <td class='text-right'>${{ number_format($payout->amount,2) }}</td>
                            <td class='text-right'>
                                @if (isset($payout->payment_id))
                                    <a href = "{{ URL('/payment/'.$payout->payment_id)}}">${{ number_format($payout->total_fee_amount,2) }} </a>
                                @else
                                    {!! Html::link(action([\App\Http\Controllers\StripePayoutController::class, 'process_fees'],$payout->id),'Create Stripe Fee Payment for $'.number_format($payout->total_fee_amount,2),array('class' => 'btn btn-warning'))!!}
                                @endIf
                            </td>
                            <td class='text-right'>${{ number_format($payout->amount + $payout->total_fee_amount,2) }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </section>
@stop

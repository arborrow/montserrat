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
                {{ html()->a(url(action([\App\Http\Controllers\StripePayoutController::class, 'import'])), 'Import New Stripe Payouts')->class('btn btn-secondary') }}

                <table class="table table-bordered table-striped table-hover"><caption><h2>Stripe Payouts ({{ $payouts->total() }})</h2></caption>
                    <thead>
                        <tr>
                            <th>Date (# Unreconciled)</th>
                            <th class='text-right'>Amount</th>
                            <th class='text-right'>Fees</th>
                            <th class='text-right'>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($payouts as $payout)
                        @if ($payout->transactions->count() == 0)
                            <tr class='table-primary'>
                        @else 
                            @if ($payout->unreconciled_count == 0)
                                <tr class='table-success'>
                            @else
                                <tr class='table-warning'>
                            @endIf
                        @endIf
                            <td>
                                <a href="{{ URL('stripe/payout/' . $payout->payout_id) }} ">{{ $payout->date->format('M d, Y') }}</a> 
                                @if ($payout->unreconciled_count > 0)
                                    ({{$payout->unreconciled_count}})
                                @endIf
                            </td>
                            <td class='text-right'>${{ number_format($payout->amount,2) }}</td>
                            <td class='text-right'>
                                @if (isset($payout->fee_payment_id))
                                    <a href = "{{ URL('/payment/'.$payout->fee_payment_id)}}">${{ number_format($payout->total_fee_amount,2) }} </a>
                                @else
                                    {{ html()->a(url(action([\App\Http\Controllers\StripePayoutController::class, 'process_fees'], $payout->id)), 'Create Stripe Fee Payment for $' . number_format($payout->total_fee_amount, 2))->class('btn btn-warning') }}
                                @endIf
                            </td>
                            <td class='text-right'>${{ number_format($payout->amount + $payout->total_fee_amount,2) }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

                <table class='table-bordered'>
                    <caption>Legend</caption>
                    <tbody>
                        <tr class="table-primary">
                            <td class='p-1'>Unimported Stripe Balance Transactions</td>
                        </tr>
                        <tr class="table-warning">
                            <td class='p-1'>Unprocessed Stripe Balance Transactions</td>
                        </tr>
                        <tr class="table-success">
                            <td class='p-1'>Stripe Balance Transactions Imported and Processed</td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </section>
@stop

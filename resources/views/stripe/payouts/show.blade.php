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

            <table class="table table-bordered table-striped table-hover"><caption><h2>Payout transactions</h2></caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gross</th>
                        <th>Fee</th>
                        <th>Net</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Available</th>
                        <th>Type</th>
                        <th>Source</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>${{ number_format($transaction->amount/100,2) }}</td>
                        <td>${{ number_format($transaction->fee/100,2) }}</td>
                        <td>${{ number_format($transaction->net/100,2) }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ \Carbon\Carbon::parse($payout->created) }}</td>
                        <td>{{ \Carbon\Carbon::parse($payout->available) }}</td>
                        <td>{{ $transaction->type }}</td>
                        <td><a href="{{ URL('stripe/'.$transaction->type.'/'. $transaction->source) }}">{{ $transaction->source }}</a></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
</section>
@stop

@extends('template')
@section('content')
    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Most recent Stripe payouts</span>
                    </h1>
                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Recent Stripe payouts</h2></caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($payouts as $payout)
                        <tr>
                            <td><a href={{ URL('stripe/payout/' . $payout->id) }} ">{{ $payout->id }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($payout->date) }} </td>
                            <td>${{ number_format($payout->amount/100,2) }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>
    </section>
@stop

@extends('template')
@section('content')
    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Most recent Stripe charges</span>
                    </h1>
                </div>

                <table class="table table-bordered table-striped table-hover"><caption><h2>Recent Stripe charges</h2></caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($charges as $charge)
                        <tr>
                            <td><a href="{{ URL('stripe/charge/' . $charge->id) }} ">{{ $charge->id }}</a></td>
                            <td> {{ \Carbon\Carbon::parse($charge->created) }}</td>
                            <td> <a href="{{ URL('stripe/customer/'. $charge->customer) }}"> {{  $charge->customer }} </a></td>
                            <td>${{ number_format($charge->amount/100,2) }}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>
    </section>
@stop

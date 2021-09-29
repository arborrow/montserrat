@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Payment Index</span>
                        <a href={{ action('PaymentController@search') }}>
                            {!! Html::image('images/search.png', 'Search payments',array('title'=>"Search payments",'class' => 'btn btn-link')) !!}</a>
                        <span class="grey">({{$payments->total()}} records)</span>
                        <!-- payments are not created independently of donations so there should not be an option here to create a payment -->
                    </h1>
                    <span>{{ $payments->links() }}</span>
                </div>
                @if ($payments->isEmpty())
                    <p>It is an impoverished new world, there are no donations!</p>
                @else
                <table class="table table-bordered table-striped table-hover table-responsive"><caption><h2>Payments</h2></caption>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount Pledged/Paid (%)</th>
                            <th>Method</th>
                            <th>ID Number</th>
                            <th>Retreat</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($payments as $payment)
                        <tr>

                            <td><a href="payment/{{ $payment->payment_id}}">{{ date('M d, Y g:i A', strtotime($payment->payment_date)) }}</a></td>
                            <td>{{ $payment->donation->donation_description ?? 'Unspecified' }} </td>
                            <td>${{ $payment->donation_amount }} / ${{ $payment->payment_amount }} ({{$payment->donation->percent_paid}}%)</td>
                            <td></td>
                            <td>{{ $payment->payment_description }}</td>
                            <td>{{ $payment->ccnumber ?? $payment->cknumber}}</td>
                            <td>{{ $payment->donation->retreat->title ?? 'N/A'}}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
                {{ $payments->links() }}

                @endif
            </div>
        </div>
    </section>
@stop

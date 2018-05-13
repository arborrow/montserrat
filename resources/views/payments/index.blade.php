@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Payment Index</span> 
                        <span class="grey">({{$payments->total()}} records)</span> 
                        @can('create-payment')
                            <span class="create">
                                <a href={{ action('PaymentsController@create') }}>{!! Html::image('img/create.png', 'Add Donation',array('title'=>"Add Donation",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                        @endCan
                    </h1>
                    <span>{!! $payments->render() !!}</span>
                </div>
                @if ($payments->isEmpty())
                    <p>It is an impoverished new world, there are no donations!</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Payments</h2></caption>
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
                            <td>{{ $payment->donation->donation_description or 'Unspecified' }} </td>
                            <td>${{ number_format($payment->donation->donation_amount,2) }} / ${{ number_format($payment->payment_amount,2) }} ({{number_format($payment->donation->percent_paid,0)}}%)</td>
                            <td></td>
                            <td>{{ $payment->payment_description }}</td>
                            <td>{{ $payment->ccnumber or $payment->cknumber}}</td>
                            <td>{{ $payment->donation->retreat->title or 'N/A'}}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                    
                </table>
                {!! $payments->render() !!}    
                    
                @endif
            </div>
        </div>
    </section>
@stop
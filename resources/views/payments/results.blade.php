@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <span class="grey">{{$payments->total()}} result(s) found</span>
                    <span class="search"><a href={{ action('PaymentController@search') }}>{!! Html::image('images/search.png', 'New search',array('title'=>"New search",'class' => 'btn btn-link')) !!}</a></span></h1>
            </div>
            @if ($payments->isEmpty())
            <p>Oops, no known payments with the given search criteria</p>
            @else
            <table class="table table-striped table-bordered table-hover table-responsive">
                <caption>
                    <h2>Payments</h2>
                </caption>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Donor</th>
                        <th>Description</th>
                        <th>Event</th>
                        <th>Payment amount</th>
                        <th>Method</th>
                        <th>ID</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td><a href="{{ URL('payment/'. $payment->payment_id) }}">{{ date('M d, Y g:i A', strtotime($payment->payment_date)) }}</a></td>
                        <td>{!! $payment->donation->contact->contact_link_full_name ?? 'Unknown contact' !!} </td>
                        <td>{{ $payment->donation->donation_description }} </td>
                        <td>{!! $payment->donation->retreat_link !!}</td>
                        <td>{{ '$'.$payment->payment_amount }} / ({{'$'.$payment->donation->donation_amount  }})</td>
                        <td>{{ $payment->payment_description }} </td>
                        <td>{{ $payment->payment_number }} </td>
                        <td>{{ $payment->note }}</td>
                    </tr>
                    @endforeach
                    {{ $payments->links() }}
                </tbody>
            </table>
            @endif
        </div>
    </div>
</section>
@stop

@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>
            @can('update-donation')
                <a href="{{url('donation/'.$donation->donation_id.'/edit')}}">Donation details</a>
            @else
                Donation details
            @endCan
            for {!!$donation->contact->contact_link_full_name!!}
        </h1>
        {!! Html::link(action('PageController@finance_invoice',$donation->donation_id),'Invoice',array('class' => 'btn btn-outline-dark'))!!}
        @can('create-payment')
            {!! Html::link(action('PaymentController@create',$donation->donation_id),'Add payment',array('class' => 'btn btn-outline-dark'))!!}
        @endCan
    </div>
    <div class="col-12 mt-2">
        @if ($donation->percent_paid == 100)
            <a href="/donation/{{$donation->donation_id}}/agcacknowledge"><img src="{{URL('/images/letter.png')}}" alt="Print acknowledgement" title="Print acknowledgement"></a>
            <a href="/person/{{$donation->contact_id}}/envelope10"><img src="{{URL('/images/envelope.png')}}" alt="Print envelope" title="Print envelope"></a>
        @endIf
    </div>
    <div class="col-12 col-md-4">
        <span class="font-weight-bold">Date: </span>{{$donation->donation_date->format('m/d/Y')}}
        <br><span class="font-weight-bold">Description: </span>{{$donation->donation_description}}
        <br><span class="font-weight-bold">Pledged/Paid: </span>${{number_format($donation->donation_amount,2)}} / ${{number_format($donation->payments->sum('payment_amount'),2)}}
        ({{$donation->percent_paid}}%)
        <br><span class="font-weight-bold">Primary contact: </span>{{$donation->Notes1}}
    </div>
    <div class="col-12 col-md-4">
        <span class="font-weight-bold">Event: </span>{!!$donation->retreat_link!!} ({{$donation->retreat_start_date}})
        <br><span class="font-weight-bold">Notes: </span>{{$donation->Notes}}
        <br><span class="font-weight-bold">Terms: </span>{{$donation->terms}}
        <br><span class="font-weight-bold">Start date: </span>{{$donation->start_date}}
    </div>
    <div class="col-12 col-md-4">
        <span class="font-weight-bold">End date: </span>{{$donation->end_date}}
        <br><span class="font-weight-bold">Donation install: </span>{{$donation->donation_install}}
        <br><span class="font-weight-bold">Thank you sent: </span>{{$donation['Thank You']}}
    </div>
    <div class="col-12 mt-3">
        <table class="table table-bordered table-striped table-hover table-responsive-md">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Check or CC#</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donation->payments as $payment)
                <tr>
                    <td><a href="../payment/{{ $payment->payment_id}}">{{$payment->payment_date_formatted}}</a></td>
                    <td>${{ $payment->payment_amount }} </td>
                    <td>{{ $payment->payment_description }}</td>
                    <td>{{ $payment->cknumber ?? $payment->ccnumber }}</td>
                    <td>{{ $payment->note }}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-6 text-right">
                @can('update-donation')
                    <a href="{{ action('DonationController@edit', $donation->donation_id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-6 text-left">
                @can('delete-donation')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['donation.destroy', $donation->donation_id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>
@stop

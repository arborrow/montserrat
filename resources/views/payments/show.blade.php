@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>
            @can('update-payment')
                <a href="{{url('payment/'.$payment->payment_id.'/edit')}}">Payment Details</a>
            @else
                Payment Details
            @endCan
            for <a href="{{url('donation/'.$payment->donation->donation_id)}}">Donation #{{$payment->donation->donation_id}}</a>
            ({!!$payment->donation->contact->contact_link_full_name!!})
        </h2>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Date: </span>{{$payment->payment_date->format('m/d/Y')}}
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Amount: </span>${{ number_format($payment->payment_amount,2)}}
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Method: </span>{{$payment->payment_description}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Check/CC#: </span>{{ $payment->ccnumber ?? $payment->cknumber}}
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Note: </span>{{$payment->note}}
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <h2>Donation Details</h2>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Date: </span> {{$payment->donation->donation_date->format('m/d/Y')}}
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Description: </span>{{$payment->donation->donation_description}}
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Amount pledged (% paid): </span>${{$payment->donation->donation_amount}} ({{$payment->donation->percent_paid}}%)
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Terms: </span>{{$payment->donation->terms}}
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Notes: </span>{{$payment->donation->notes}}
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Start date: </span>{{$payment->donation->start_date}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">End date: </span>{{$payment->donation->end_date}}
            </div>
            <div class="col-lg-3 col-md-4">
                <span class="font-weight-bold">Donation install: </span>{{$payment->donation->donation_install}}
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="row">
            <div class="col-lg-6 text-right">
                @can('update-payment')
                    <a href="{{ action([\App\Http\Controllers\PaymentController::class, 'edit'], $payment->payment_id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-payment')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['payment.destroy', $payment->payment_id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>
@stop

@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit payment for <a href="{{url('donation/'.$payment->donation->donation_id)}}">Donation {{$payment->donation->donation_id}}</a></h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['payment.update', $payment->payment_id]]) !!}
        {!! Form::hidden('donation_id', $payment->donation->donation_id) !!}
            <div class="form-group">
                <h2>Payment Details</h2>
                <div class="row">
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('payment_date', 'Payment date')  !!}
                        {!! Form::date('payment_date', $payment->payment_date, ['class' => 'form-control flatpickr-date']) !!}
                    </div>
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('payment_amount', 'Payment amount (paid)')  !!}
                        {!! Form::number('payment_amount', $payment->payment_amount, ['class' => 'form-control','step'=>'0.01']) !!}
                    </div>
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('payment_description', 'Payment method')  !!}
                        {!! Form::select('payment_description', $payment_methods, $payment->payment_description, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('payment_idnumber', 'Check/CC Number')  !!}
                        {!! Form::number('payment_idnumber', $payment->payment_number, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('note', 'Note')  !!}
                        {!! Form::text('note', $payment->note, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Donation Details</h2>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-4">
                            <span class="font-weight-bold">Date: </span>{{$payment->donation->donation_date->format('m/d/Y')}}
                        </div>
                        <div class="col-lg-12 col-md-4">
                            <span class="font-weight-bold">Description: </span>{{$payment->donation->donation_description}}
                        </div>
                        <div class="col-lg-12 col-md-4">
                            <span class="font-weight-bold">Pledged/Paid: </span>${{number_format($payment->donation->donation_amount,2)}} / ${{number_format($payment->donation->payments->sum('payment_amount'),2)}} ({{$payment->donation->percent_paid}}%)
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-4">
                            <span class="font-weight-bold">Terms: </span>{{$payment->donation->terms}}
                        </div>
                        <div class="col-lg-12 col-md-4">
                            <span class="font-weight-bold">Notes: </span>{{$payment->donation->notes}}
                        </div>
                        <div class="col-lg-12 col-md-4">
                            <span class="font-weight-bold">Start date: </span>{{$payment->donation->start_date}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-4">
                            <span class="font-weight-bold">End date: </span>{{$payment->donation->end_date}}
                        </div>
                        <div class="col-lg-12 col-md-4">
                            <span class="font-weight-bold">Donation install: </span>{{$payment->donation->donation_install}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    {!! Form::submit('Update payment', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

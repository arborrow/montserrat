@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit payment for <a href="{{url('donation/'.$payment->donation->donation_id)}}">Donation {{$payment->donation->donation_id}}</a></h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('payment.update', [$payment->payment_id]))->open() }}
        {{ html()->hidden('donation_id', $payment->donation->donation_id) }}
            <div class="form-group">
                <h2>Payment Details</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Payment date', 'payment_date') }}
                        {{ html()->date('payment_date', $payment->payment_date)->class('form-control flatpickr-date') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Payment amount (paid)', 'payment_amount') }}
                        {{ html()->number('payment_amount', $payment->payment_amount)->class('form-control')->attribute('step', '0.01') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Payment method', 'payment_description') }}
                        {{ html()->select('payment_description', $payment_methods, $payment->payment_description)->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Check/CC Number', 'payment_idnumber') }}
                        {{ html()->number('payment_idnumber', $payment->payment_number)->class('form-control') }}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {{ html()->label('Note', 'note') }}
                        {{ html()->text('note', $payment->note)->class('form-control') }}
                    </div>
                    @if ($payment->payment_description == "Credit card" && !isset($payment->stripe_balance_transaction_id))
                        <div class="col-lg-3 col-md-4">
                            {{ html()->label('Balance Transaction ID', 'stripe_balance_transaction_id') }}
                            {{ html()->number('stripe_balance_transaction_id', $payment->stripe_balance_transaction_id)->class('form-control') }}
                        </div>
                    @else
                        {{ html()->hidden('stripe_balance_transaction_id', $payment->stripe_balance_transaction_id) }}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Donation Details</h2>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <span class="font-weight-bold">Date: </span>{{$payment->donation->donation_date->format('m/d/Y')}}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <span class="font-weight-bold">Description: </span>{{$payment->donation->donation_description}}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <span class="font-weight-bold">Pledged/Paid: </span>${{number_format($payment->donation->donation_amount,2)}} / ${{number_format($payment->donation->payments->sum('payment_amount'),2)}} ({{$payment->donation->percent_paid}}%)
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
            </div>
            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    {{ html()->submit('Update payment')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop

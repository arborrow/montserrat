@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create payment for <a href="{{url('donation/'.$donation->donation_id)}}">Donation {{$donation->donation_id}}</a></h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('payment'))->open() }}
        {{ html()->hidden('donation_id', $donation->donation_id) }}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Payment Details</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Payment date', 'payment_date') }}
                        {{ html()->date('payment_date', \Carbon\Carbon::now())->class('form-control flatpickr-date') }}
                    </div>
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Payment amount (paid)', 'payment_amount') }}
                        {{ html()->number('payment_amount', 0)->class('form-control')->attribute('step', '0.01') }}
                    </div>
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Payment method', 'payment_description') }}
                        {{ html()->select('payment_description', $payment_methods)->class('form-control') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Check/CC Number', 'payment_idnumber') }}
                        {{ html()->number('payment_idnumber')->class('form-control') }}
                    </div>
                    <div class="col-lg-4 col-md-6">
                        {{ html()->label('Note', 'note') }}
                        {{ html()->text('note')->class('form-control') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Donation Details</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <span class="font-weight-bold">Date: </span>{{$donation->donation_date}}
                </div>
                <div class="col-lg-4 col-md-6">
                    <span class="font-weight-bold">Description: </span>{{$donation->donation_description}}
                </div>
                <div class="col-lg-4 col-md-6">
                    <span class="font-weight-bold">Pledged/Paid: </span>${{$donation->donation_amount}} / ${{$donation->payments->sum('payment_amount')}} ({{$donation->percent_paid}}%)
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <span class="font-weight-bold">Terms: </span>{{$donation->terms}}
                </div>
                <div class="col-lg-4 col-md-6">
                    <span class="font-weight-bold">Notes: </span>{{$donation->notes}}
                </div>
                <div class="col-lg-4 col-md-6">
                    <span class="font-weight-bold">Start date: </span>{{$donation->start_date}}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <span class="font-weight-bold">End date: </span>{{$donation->end_date}}
                </div>
                <div class="col-lg-4 col-md-6">
                    <span class="font-weight-bold">Donation install: </span>{{$donation->donation_install}}
                </div>
            </div>
            <div class="row mt-3 text-center">
                <div class="col-lg-12">
                    {{ html()->submit('Add payment')->class('btn btn-outline-dark') }}
                </div>
            </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop

@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Payments</strong></h1>
        </div>

        {{ html()->form('GET', route('payments.results', ))->class('form-horizontal')->open() }}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{{ html()->input('image', 'btnSave')->class('btn btn-outline-dark pull-right')->attribute('src', asset('images/submit.png')) }}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <h3 class="text-primary">Payment information</h3>

                    <div class="row">
                        <div class="col-lg-1">
                            {{ html()->label('Comp.', 'payment_date_operator') }}
                            {{ html()->select('payment_date_operator', config('polanco.operators'), '=')->class('form-control') }}
                        </div>
                        <div class="col-lg-2">
                            {{ html()->label('Date', 'payment_date') }}
                            {{ html()->date('payment_date')->class('form-control flatpickr-date') }}
                        </div>
                        <div class="col-lg-1">
                            {{ html()->label('Comp.', 'payment_amount_operator') }}
                            {{ html()->select('payment_amount_operator', config('polanco.operators'), '=')->class('form-control') }}
                        </div>
                        <div class="col-lg-2">
                            {{ html()->label('Amount', 'payment_amount') }}
                            {{ html()->number('payment_amount')->class('form-control')->attribute('step', '0.01') }}
                        </div>
                        <div class="col-lg-2">
                            {{ html()->label('Payment method', 'payment_description') }}
                            {{ html()->select('payment_description', $payment_methods)->class('form-control') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5">
                            {{ html()->label('Donation description', 'donation_description') }}
                            {{ html()->select('donation_description', $descriptions)->class('form-control') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            {{ html()->label('Notes', 'note') }}
                            {{ html()->text('note')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Check #', 'cknumber') }}
                            {{ html()->number('cknumber')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Credit Card #', 'ccnumber') }}
                            {{ html()->number('ccnumber')->class('form-control') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
</div>

@stop

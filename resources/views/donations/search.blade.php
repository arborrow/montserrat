@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Donations</strong></h1>
        </div>

        {{ html()->form('GET', route('donations.results', ))->class('form-horizontal')->open() }}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{{ html()->input('image', 'btnSave')->class('btn btn-outline-dark pull-right')->attribute('src', asset('images/submit.png')) }}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <h3 class="text-primary">Donation information</h3>
                    <div class="row">
                        <div class="col-lg-1">
                            {{ html()->label('Comp.', 'donation_date_operator') }}
                            {{ html()->select('donation_date_operator', config('polanco.operators'), '=')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Date', 'donation_date') }}
                            {{ html()->date('donation_date')->class('form-control flatpickr-date') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Description', 'donation_description') }}
                            {{ html()->select('donation_description', $descriptions)->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Retreat', 'event_id') }}
                            {{ html()->select('event_id', $retreats)->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">
                            {{ html()->label('Comp.', 'donation_amount_operator') }}
                            {{ html()->select('donation_amount_operator', config('polanco.operators'), '=')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Amount', 'donation_amount') }}
                            {{ html()->number('donation_amount')->class('form-control')->attribute('step', '0.01') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Primary contact for invoice', 'notes1') }}
                            {{ html()->text('notes1')->class('form-control') }}
                        </div>
                        <div class="col-lg-3 col-md-4">
                            {{ html()->label('Notes', 'notes') }}
                            {{ html()->text('notes')->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-1">
                          {{ html()->label('Comp.', 'start_date_operator') }}
                          {{ html()->select('start_date_operator', config('polanco.operators'), '=')->class('form-control') }}
                      </div>
                        <div class="col-lg-3">
                            {{ html()->label('Start date', 'start_date') }}
                            {{ html()->date('start_date')->class('form-control flatpickr-date') }}
                        </div>
                        <div class="col-lg-1">
                            {{ html()->label('Comp.', 'end_date_operator') }}
                            {{ html()->select('end_date_operator', config('polanco.operators'), '=')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('End date', 'end_date') }}
                            {{ html()->date('end_date')->class('form-control flatpickr-date') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Stripe Invoice #', 'stripe_invoice') }}
                            {{ html()->text('stripe_invoice')->class('form-control') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1">
                            {{ html()->label('Comp.', 'donation_install_operator') }}
                            {{ html()->select('donation_install_operator', config('polanco.operators'), '=')->class('form-control') }}
                        </div>
                        <div class="col-lg-3">
                            {{ html()->label('Installment', 'donation_install') }}
                            {{ html()->number('donation_install')->class('form-control')->attribute('step', '0.01') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Terms', 'terms') }}
                            {{ html()->text('terms')->class('form-control') }}
                        </div>
                        <div class="col-lg-4">
                            {{ html()->label('Thank you letter', 'donation_thank_you') }}
                            {{ html()->select('donation_thank_you', ['' => 'N/A', 'Y' => 'Yes', 'N' => 'No'])->class('form-control') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
</div>

@stop

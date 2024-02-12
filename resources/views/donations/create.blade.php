@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create Donation</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('donation'))->open() }}
            <div class="row">
                <div class="col-lg-12">
                    <h2>Basic Details</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Donor', 'donor_id') }}
                                @if (isset($defaults['donor_id']))
                                    {{ html()->select('donor_id', $donors, $defaults['donor_id'])->class('form-control') }}
                                @else
                                    {{ html()->select('donor_id', $donors)->class('form-control') }}
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-6">
                                {{ html()->label('Description', 'donation_description') }}
                                {{ html()->select('donation_description', $descriptions, 'Retreat Offering')->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-6">
                                {{ html()->label('Retreat', 'event_id') }}
                                @if (isset($defaults['event_id']))
                                    {{ html()->select('event_id', $retreats, $defaults['event_id'])->class('form-control') }}
                                @else
                                    {{ html()->select('event_id', $retreats)->class('form-control') }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Date of donation', 'donation_date') }}
                                {{ html()->text('donation_date', now())->class('flatpickr-date') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Donation amount (pledged)', 'donation_amount') }}
                                {{ html()->number('donation_amount', 0)->class('form-control')->attribute('step', '0.01') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h2>Payment Details</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Date of payment', 'payment_date') }}
                                {{ html()->text('payment_date', now())->class('flatpickr-date') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Payment amount (paid)', 'payment_amount') }}
                                {{ html()->number('payment_amount', 0)->class('form-control')->attribute('step', '0.01') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Payment method', 'payment_description') }}
                                {{ html()->select('payment_description', $payment_methods)->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Check/CC Number', 'payment_idnumber') }}
                                {{ html()->number('payment_idnumber')->class('form-control') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h2>Other Details</h2>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Primary contact for invoice', 'notes1') }}
                                {{ html()->text('notes1')->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Notes', 'notes') }}
                                {{ html()->text('notes')->class('form-control') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Terms', 'terms') }}
                                {{ html()->text('terms')->class('form-control') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Start date', 'start_date') }}
                                {{ html()->text('start_date')->class('flatpickr-date') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('End date', 'end_date') }}
                                {{ html()->text('end_date')->class('flatpickr-date') }}
                            </div>
                            <div class="col-lg-3 col-md-4">
                                {{ html()->label('Installment', 'donation_install') }}
                                {{ html()->number('donation_install', 0.0)->class('form-control')->attribute('step', '0.01') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{ html()->submit('Add donation')->class('btn btn-light') }}
                </div>
            </div>

        {{ html()->form()->close() }}
    </div>
</div>
@stop

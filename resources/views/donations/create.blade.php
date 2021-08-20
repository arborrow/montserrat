@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>Create Donation</h1>
    </div>
    <div class="col-12">
        {!! Form::open(['url' => 'donation', 'method' => 'post']) !!}
            <div class="row">
                <div class="col-12">
                    <h2>Basic Details</h2>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                {!! Form::label('donor_id', 'Donor')  !!}
                                @if (isset($defaults['donor_id']))
                                    {!! Form::select('donor_id', $donors, $defaults['donor_id'], ['class' => 'form-control']) !!}
                                @else
                                    {!! Form::select('donor_id', $donors, NULL, ['class' => 'form-control']) !!}
                                @endif
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('donation_description', 'Description')  !!}
                                {!! Form::select('donation_description', $descriptions, 'Retreat Offering', ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('event_id', 'Retreat')  !!}
                                @if (isset($defaults['event_id']))
                                    {!! Form::select('event_id', $retreats, $defaults['event_id'], ['class' => 'form-control']) !!}
                                @else
                                    {!! Form::select('event_id', $retreats, NULL, ['class' => 'form-control']) !!}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                {!! Form::label('donation_date', 'Date of donation')  !!}
                                {!! Form::text('donation_date',now() , ['class' => 'flatpickr-date']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('donation_amount', 'Donation amount (pledged)')  !!}
                                {!! Form::number('donation_amount', 0, ['class' => 'form-control','step'=>'0.01']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h2>Payment Details</h2>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                {!! Form::label('payment_date', 'Date of payment')  !!}
                                {!! Form::text('payment_date',now(), ['class' => 'flatpickr-date']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('payment_amount', 'Payment amount (paid)')  !!}
                                {!! Form::number('payment_amount', 0, ['class' => 'form-control','step'=>'0.01']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('payment_description', 'Payment method')  !!}
                                {!! Form::select('payment_description', $payment_methods, NULL, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('payment_idnumber', 'Check/CC Number')  !!}
                                {!! Form::number('payment_idnumber', NULL, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h2>Other Details</h2>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                {!! Form::label('notes1', 'Primary contact for invoice')  !!}
                                {!! Form::text('notes1', NULL, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('notes', 'Notes')  !!}
                                {!! Form::text('notes', NULL, ['class' => 'form-control']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('terms', 'Terms')  !!}
                                {!! Form::text('terms', NULL, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                {!! Form::label('start_date', 'Start date')  !!}
                                {!! Form::text('start_date', NULL, ['class'=>'flatpickr-date']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('end_date', 'End date')  !!}
                                {!! Form::text('end_date', NULL, ['class'=>'flatpickr-date']) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! Form::label('donation_install', 'Installment')  !!}
                                {!! Form::number('donation_install', 0.00, ['class' => 'form-control','step'=>'0.01']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    {!! Form::submit('Add donation', ['class'=>'btn btn-light']) !!}
                </div>
            </div>

        {!! Form::close() !!}
    </div>
</div>
@stop

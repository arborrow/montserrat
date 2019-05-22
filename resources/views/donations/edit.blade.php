@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit {!! $donation->contact->contact_link_full_name ?? 'Unknown contact' !!}'s Donation:</h1>
    </div>
    <div class="col-12">
        <h2>Donation details</h2>
        {!! Form::open(['method' => 'PUT', 'route' => ['donation.update', $donation->donation_id]]) !!}
        {!! Form::hidden('donation_id', $donation->donation_id) !!}
        {!! Form::hidden('donor_id', $donation->contact_id) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('donation_description', 'Description')  !!}
                        {!! Form::select('donation_description', $descriptions, $defaults['description_key'], ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('event_id', 'Retreat')  !!}
                        @if (isset($defaults['event_id']))
                            {!! Form::select('event_id', $retreats, $defaults['event_id'], ['class' => 'form-control']) !!}
                        @else
                            {!! Form::select('event_id', $retreats, $donation->event_id, ['class' => 'form-control']) !!}
                        @endif
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('donation_date', 'Date')  !!}
                        {!! Form::date('donation_date', $donation->donation_date, ['class'=>'form-control flatpickr-date']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('donation_amount', 'Amount')  !!}
                        {!! Form::number('donation_amount', $donation->donation_amount, ['class' => 'form-control','step'=>'0.01']) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('notes1', 'Primary contact')  !!}
                        {!! Form::text('notes1', $donation->Notes1, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('notes', 'Notes')  !!}
                        {!! Form::text('notes', $donation->Notes, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('terms', 'Terms')  !!}
                        {!! Form::text('terms', $donation->terms, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('start_date_only', 'Start date')  !!}
                        {!! Form::text('start_date_only', $donation->start_date, ['class' => 'form-control flatpickr-date']) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('end_date_only', 'End date')  !!}
                        {!! Form::text('end_date_only', $donation->end_date, ['class' => 'form-control flatpickr-date']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('donation_install', 'Installment')  !!}
                        {!! Form::number('donation_install', $donation->donation_install, ['class' => 'form-control','step'=>'0.01']) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('donation_thank_you', 'Thank you letter')  !!}
                        {!! Form::select('donation_thank_you', ['Y' => 'Yes','N' => 'No'], $donation->donation_thank_you_sent, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-12">
                        {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

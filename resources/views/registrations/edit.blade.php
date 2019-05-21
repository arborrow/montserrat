@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>
            Edit Registration #{!! $registration->id !!} for {!!$registration->retreatant->contact_link!!}
        </h1>
    </div>
    <div class="col-12">
        {!! Form::open(['method' => 'PUT', 'route' => ['registration.update', $registration->id]]) !!}
        {!! Form::hidden('id', $registration->id) !!}

        <div class="form-group">
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('event_id', 'Retreat') !!}
                    {!! Form::select('event_id', $retreats, $registration->event_id, ['class' => 'form-control']) !!}
                    {!! Form::label('start', 'Retreat Dates: '.date('M j, Y', strtotime($registration->retreat->start_date)).' - '.date('M j, Y', strtotime($registration->retreat->end_date))) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('register_date', 'Registered') !!}
                    {!! Form::text('register_date', $registration->register_date, ['class'=>'form-control flatpickr-date']) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('source', 'Registration from:') !!}
                    {!! Form::select('source', $defaults['registration_source'], $registration->source, ['class' => 'form-control']) !!} 
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('status_id', 'Status:') !!}
                    {!! Form::select('status_id', $defaults['participant_status_type'], $registration->status_id, ['class' => 'form-control']) !!} 
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('registration_confirm_date', 'Registration Confirmed:') !!}
                    @if ($registration->registration_confirm_date == NULL)
                        {!! Form::text('registration_confirm_date', NULL, ['class'=>'form-control flatpickr-date']) !!}
                    @else
                        {!! Form::text('registration_confirm_date', $registration->registration_confirm_date, ['class'=>'form-control flatpickr-date']) !!}
                    @endif
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('confirmed_by', 'Confirmed by:') !!}
                    {!! Form::text('confirmed_by', $registration->confirmed_by, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('arrived_at', 'Arrived at:') !!}
                    {!! Form::text('arrived_at', $registration->arrived_at, ['class'=>'form-control flatpickr-date']) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('departed_at', 'Departed at:') !!}
                    {!! Form::text('departed_at', $registration->departed_at, ['class'=>'form-control flatpickr-date']) !!}
                </div>
                <div class="col-12 col-md-4">
                    {!! Form::label('canceled_at', 'Canceled at:') !!}
                    {!! Form::text('canceled_at', $registration->canceled_at, ['class'=>'form-control flatpickr-date']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('room_id', 'Room:')  !!}
                    {!! Form::select('room_id', $rooms, $registration->room_id, ['class' => 'form-control']) !!} 
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('deposit', 'Deposit:') !!}
                    {!! Form::text('deposit', $registration->deposit, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    {!! Form::label('notes', 'Notes:') !!}
                    {!! Form::textarea('notes', $registration->notes, ['class'=>'form-control', 'rows'=>'3']) !!}
                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-12">
                    {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-light']) !!}
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop

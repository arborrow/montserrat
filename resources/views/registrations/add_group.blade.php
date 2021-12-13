@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Add A Registration</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url' => 'registration/add_group', 'method' => 'post']) !!}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('event_id', 'Retreat:') !!}
                    {!! Form::select('event_id', $retreats, $defaults['retreat_id'], ['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('group_id', 'Group:') !!}
                    {!! Form::select('group_id', $groups, $defaults['group_id'], ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('register_date', 'Registered:') !!}
                    {!! Form::text('register_date', $defaults['today'], ['class'=>'form-control flatpickr-date-time']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('source', 'Registration from:') !!}
                    {!! Form::select('source', $defaults['registration_source'], 'N/A', ['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('status_id', 'Status:') !!}
                    {!! Form::select('status_id', $defaults['participant_status_type'], NULL, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('registration_confirm_date', 'Registration Confirmed:') !!}
                    {!! Form::text('registration_confirm_date', null, ['class'=>'form-control flatpickr-date']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('confirmed_by', 'Confirmed By:') !!}
                    {!! Form::text('confirmed_by', null, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('arrived_at', 'Arrived at:') !!}
                    {!! Form::text('arrived_at', null, ['class'=>'form-control flatpickr-date']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('departed_at', 'Departed at:') !!}
                    {!! Form::text('departed_at', null, ['class'=>'form-control flatpickr-date']) !!}
                </div>
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('canceled_at', 'Canceled at:') !!}
                    {!! Form::text('canceled_at', null, ['class'=>'form-control flatpickr-date']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-4">
                    {!! Form::label('deposit', 'Deposit:') !!}
                    {!! Form::text('deposit', '0.00', ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::label('notes', 'Notes:') !!}
                    {!! Form::textarea('notes', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    {!! Form::submit('Add Group Registration', ['class'=>'btn btn-light']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

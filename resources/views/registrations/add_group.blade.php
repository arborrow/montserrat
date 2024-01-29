@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Add A Registration</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', 'registration/add_group')->open() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Retreat:', 'event_id') }}
                    {{ html()->select('event_id', $retreats, $defaults['retreat_id'])->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Group:', 'group_id') }}
                    {{ html()->select('group_id', $groups, $defaults['group_id'])->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Registered:', 'register_date') }}
                    {{ html()->text('register_date', $defaults['today'])->class('form-control flatpickr-date-time') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Registration from:', 'source') }}
                    {{ html()->select('source', $defaults['registration_source'], 'N/A')->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Status:', 'status_id') }}
                    {{ html()->select('status_id', $defaults['participant_status_type'])->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Registration Confirmed:', 'registration_confirm_date') }}
                    {{ html()->text('registration_confirm_date')->class('form-control flatpickr-date') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Confirmed By:', 'confirmed_by') }}
                    {{ html()->text('confirmed_by')->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Arrived at:', 'arrived_at') }}
                    {{ html()->text('arrived_at')->class('form-control flatpickr-date') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Departed at:', 'departed_at') }}
                    {{ html()->text('departed_at')->class('form-control flatpickr-date') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Canceled at:', 'canceled_at') }}
                    {{ html()->text('canceled_at')->class('form-control flatpickr-date') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Deposit:', 'deposit') }}
                    {{ html()->text('deposit', '0.00')->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ html()->label('Notes:', 'notes') }}
                    {{ html()->textarea('notes')->class('form-control')->rows('3') }}
                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    {{ html()->submit('Add Group Registration')->class('btn btn-light') }}
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop

@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Edit Registration #{!! $registration->id !!} for {!!$registration->retreatant->contact_link!!}
        </h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('PUT', route('registration.update', [$registration->id]))->open() }}
        {{ html()->hidden('id', $registration->id) }}

        <div class="form-group">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Retreat', 'event_id') }}
                    {{ html()->select('event_id', $retreats, $registration->event_id)->class('form-control') }}
                    {{ html()->label('Retreat Dates: ' . date('M j, Y', strtotime($registration->retreat->start_date)) . ' - ' . date('M j, Y', strtotime($registration->retreat->end_date)), 'start') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Registered', 'register_date') }}
                    {{ html()->date('register_date', isset($registration->register_date) ? $registration->register_date : now())->class('form-control flatpickr-date') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Registration from:', 'source') }}
                    {{ html()->select('source', $defaults['registration_source'], $registration->source)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Status:', 'status_id') }}
                    {{ html()->select('status_id', $defaults['participant_status_type'], $registration->status_id)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Registration Confirmed:', 'registration_confirm_date') }}
                    @if ($registration->registration_confirm_date == NULL)
                        {{ html()->date('registration_confirm_date')->class('form-control flatpickr-date') }}
                    @else
                        {{ html()->date('registration_confirm_date', $registration->registration_confirm_date)->class('form-control flatpickr-date') }}
                    @endif
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Confirmed by:', 'confirmed_by') }}
                    {{ html()->text('confirmed_by', $registration->confirmed_by)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Arrived at:', 'arrived_at') }}
                    {{ html()->datetime('arrived_at', $registration->arrived_at)->class('form-control flatpickr-date-time') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Departed at:', 'departed_at') }}
                    {{ html()->datetime('departed_at', $registration->departed_at)->class('form-control flatpickr-date-time') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Canceled at:', 'canceled_at') }}
                    {{ html()->date('canceled_at', $registration->canceled_at)->class('form-control flatpickr-date') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Room:', 'room_id') }}
                    {{ html()->select('room_id', $rooms, $registration->room_id)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Deposit:', 'deposit') }}
                    {{ html()->text('deposit', $registration->deposit)->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Notes:', 'notes') }}
                    {{ html()->textarea('notes', $registration->notes)->class('form-control')->rows('3') }}
                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-lg-12">
                    {{ html()->input('image', 'btnSave')->class('btn btn-light')->attribute('src', asset('images/save.png')) }}
                </div>
            </div>
        </div>

        {{ html()->form()->close() }}
    </div>
</div>
@stop

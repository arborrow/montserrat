@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Add A Registration</h1>
    </div>
    <div class="col-lg-12">
        {{ html()->form('POST', url('registration'))->open() }}
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Retreat:', 'event_id') }}
                    {{ html()->select('event_id', $retreats, $defaults['retreat_id'])->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Retreatant:', 'contact_id') }}
                    @if (isset($defaults['contact_id']))
                        {{ html()->select('contact_id', $retreatants, $defaults['contact_id'])->class('form-control') }}
                    @else
                        {{ html()->select('contact_id', $retreatants, 0)->class('form-control') }}
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Registered:', 'register_date') }}
                    {{ html()->text('register_date', now())->class('form-control flatpickr-date-time') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Registration from:', 'source') }}
                    {{ html()->select('source', $defaults['registration_source'], 'N/A')->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Status:', 'status_id') }}
                    {{ html()->select('status_id', $defaults['participant_status_type'], 1)->class('form-control') }}
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
                    {{ html()->label('Room(s):', 'rooms') }}
                    {{ html()->multiselect('rooms[]', $rooms, 0)->class('form-control') }}
                </div>
                <div class="col-lg-3 col-md-4">
                    @if ($defaults['is_multi_registration'])
                        {{ html()->label('Number of participants:', 'num_registrants') }}
                        {{ html()->select('num_registrants', options_range(0, 99))->class('form-control') }}
                    @endIf
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    {{ html()->label('Deposit:', 'deposit') }}
                    {{ html()->text('deposit', '50.00')->class('form-control') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ html()->label('Notes:', 'notes') }}
                    {{ html()->textarea('notes')->class('form-control')->rows('3') }}
                </div>
            </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    {{ html()->submit('Add Registration')->class('btn btn-light') }}
                </div>
            </div>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>
@stop

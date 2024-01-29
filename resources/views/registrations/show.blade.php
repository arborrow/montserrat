@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Details for

            @can('update-registration')
                <a href="{{url('registration/'.$registration->id.'/edit')}}">Registration #{{ $registration->id }}</a>
            @else
                Registration #{{ $registration->id }}
            @endCan

            <span class="back"><a href={{ action([\App\Http\Controllers\RegistrationController::class, 'index']) }}>{{ html()->img(asset('images/registration.png'), 'Registration Index')->attribute('title', "Registration Index")->class('btn btn-light') }}</a>

            @can('update-registration')
                @if (empty($registration->registration_confirm_date))
                    <a href="{{ action([\App\Http\Controllers\RegistrationController::class, 'send_confirmation_email'],$registration->id) }}" class="btn btn-light">Send confirmation email</a>
                @endIf
            @endCan
        </h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <strong>Retreatant: </strong><a href="../person/{{ $registration->retreatant->id}}">{{ $registration->retreatant->full_name}}</a>
            </div>
            <div class="col-lg-3 col-md-4">
                <strong>Retreat: </strong><a href="../retreat/{{ $registration->event_id}}">{{ $registration->event_name}} ({{ $registration->event_idnumber}})</a>
            </div>
            <div class="col-lg-3 col-md-4">
                <strong>Retreat Dates: </strong>{{ date('F d, Y', strtotime($registration->retreat_start_date))}} - {{ date('F d, Y', strtotime($registration->retreat_end_date))}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <strong>Registered: </strong>{{ isset($registration->register_date) ? date('F d, Y h:i A', strtotime($registration->register_date)) : null }}
            </div>
            <div class="col-lg-3 col-md-4">
                <strong>Status: </strong>{{ $registration->status_name }}
            </div>
            <div class="col-lg-3 col-md-4">
                <strong>Registration from: </strong>{{ $registration->source ? $registration->source : 'N/A' }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <strong>Registration Confirmed: </strong>
                @if ($registration->registration_confirm_date == NULL)
                    N/A
                @else
                    {{date('F d, Y', strtotime($registration->registration_confirm_date))}}
                @endif
            </div>
            <div class="col-lg-3 col-md-4">
                <strong>Confirmed by: </strong>{{ $registration->confirmed_by}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <strong>Arrived at: </strong>
                @if (empty($registration->arrived_at))
                    N/A
                @else
                    {{date('F d, Y H:i', strtotime($registration->arrived_at))}}
                @endif
            </div>
            <div class="col-lg-3 col-md-4">
                <strong>Departed at: </strong>
                @if ($registration->departed_at == NULL)
                    N/A
                @else
                    {{date('F d, Y H:i', strtotime($registration->departed_at))}}
                @endif
            </div>
            <div class="col-lg-3 col-md-4">
                <strong>Canceled at: </strong>
                @if ($registration->canceled_at == NULL)
                    N/A
                @else
                    {{date('F d, Y', strtotime($registration->canceled_at))}}
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <strong>Room: </strong>{{ $registration->room_name}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <strong>Notes: </strong>{{ $registration->notes }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <strong>Deposit: </strong>${{ $registration->deposit}}
            </div>
        </div>
        <div class="row">
            @can('delete-registration')
                <div class="col-lg-12">
                    <strong>Encoded Registration Link: </strong>
                    @if (isset($registration->remember_token) && !isset($registration->registration_confirm_date))
                        <a href={{  url('intercept/'.base64_encode("registration/confirm/$registration->remember_token")) }}>
                            {{  url('intercept/'.base64_encode("registration/confirm/$registration->remember_token")) }}
                        </a>
                    @else
                        {{ isset($registration->registration_confirm_date) ? 'Confirmed' : 'N/A' }}
                    @endIf
                </div>
            @endCan
        </div>
        <div class="row mt-3">
            <div class="col-lg-6 text-right">
                @can('update-registration')
                    <a href="{{ action([\App\Http\Controllers\RegistrationController::class, 'edit'], $registration->id) }}" class="btn btn-info">{{ html()->img(asset('images/edit.png'), 'Edit')->attribute('title', "Edit") }}</a>
                @endCan
            </div>
            <div class="col-lg-6 text-left">
                @can('delete-registration')
                    {{ html()->form('DELETE', route('registration.destroy', [$registration->id]))->attribute('onsubmit', 'return ConfirmDelete()')->open() }}
                    {{ html()->input('image', 'btnDelete')->class('btn btn-danger')->attribute('title', 'Delete')->attribute('src', asset('images/delete.png')) }}
                    {{ html()->form()->close() }}
                @endCan
            </div>
        </div>
        </div>
    </div>
</div>
@stop

@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>
            Details for
            @can('update-registration')
                <a href="{{url('registration/'.$registration->id.'/edit')}}">Registration #{{ $registration->id }}</a>
            @else
                Registration #{{ $registration->id }}
            @endCan
            <span class="back"><a href={{ action('RegistrationController@index') }}>{!! Html::image('images/registration.png', 'Registration Index',array('title'=>"Registration Index",'class' => 'btn btn-light')) !!}</a>
        </h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-4">
                <strong>Retreatant: </strong><a href="../person/{{ $registration->retreatant->id}}">{{ $registration->retreatant->full_name}}</a>
            </div>
            <div class="col-12 col-md-4">
                <strong>Retreat: </strong><a href="../retreat/{{ $registration->event_id}}">{{ $registration->retreat->title}} ({{ $registration->retreat->idnumber}})</a>
            </div>
            <div class="col-12 col-md-4">
                <strong>Retreat Dates: </strong>{{ date('F d, Y', strtotime($registration->retreat->start_date))}} - {{ date('F d, Y', strtotime($registration->retreat->end_date))}}
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <strong>Registered: </strong>{{ date('F d, Y h:i A', strtotime($registration->register_date))}}
            </div>
            <div class="col-12 col-md-4">
                <strong>Status: </strong>{{ $registration->status_name }}
            </div>
            <div class="col-12 col-md-4">
                <strong>Registration from: </strong>{{ $registration->source ? $registration->source : 'N/A' }}
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <strong>Registration Confirmed: </strong>
                @if ($registration->registration_confirm_date == NULL)
                    N/A
                @else
                    {{date('F d, Y', strtotime($registration->registration_confirm_date))}}
                @endif
            </div>
            <div class="col-12 col-md-4">
                <strong>Confirmed by: </strong>{{ $registration->confirmed_by}}
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <strong>Arrived at: </strong>
                @if (empty($registration->arrived_at))
                    N/A
                @else
                    {{date('F d, Y H:i', strtotime($registration->arrived_at))}}
                @endif
            </div>
            <div class="col-12 col-md-4">
                <strong>Departed at: </strong>
                @if ($registration->departed_at == NULL)
                    N/A
                @else
                    {{date('F d, Y H:i', strtotime($registration->departed_at))}}
                @endif
            </div>
            <div class="col-12 col-md-4">
                <strong>Canceled at: </strong>
                @if ($registration->canceled_at == NULL)
                    N/A
                @else
                    {{date('F d, Y', strtotime($registration->canceled_at))}}
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <strong>Room: </strong>{{ $registration->room_name}}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <strong>Notes: </strong>{{ $registration->notes }}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <strong>Deposit: </strong>${{ $registration->deposit}}
            </div>
        </div>
        <div class="row">
            @can('delete-registration')
                <div class="col-12">
                    <strong>Encoded Registration Link: </strong> <a href={{  url('intercept/'.base64_encode("registration/confirm/$registration->remember_token")) }}>{{  url('intercept/'.base64_encode("registration/confirm/$registration->remember_token")) }}</a>
                </div>
            @endCan
        </div>
        <div class="row mt-3">
            <div class="col-6 text-right">
                @can('update-registration')
                    <a href="{{ action('RegistrationController@edit', $registration->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-6 text-left">
                @can('delete-registration')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['registration.destroy', $registration->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                    {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                    {!! Form::close() !!}
                @endCan
            </div>
        </div>
        </div>
    </div>
</div>
@stop

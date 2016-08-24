@extends('template')
@section('content')

    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span><h2>Details for Registration #{!! $registration->id !!}</span>
                    <span class="back"><a href={{ action('RegistrationsController@index') }}>{!! Html::image('img/registration.png', 'Registration Index',array('title'=>"Registration Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Retreatant: </strong><a href="../person/{{ $registration->retreatant->id}}">{{ $registration->retreatant->display_name}}</a></div>
                </div><div class="clearfix"> </div>
                         <div class='row'>
                    <div class='col-md-3'><strong>Retreat: </strong><a href="../retreat/{{ $registration->event_id}}">{{ $registration->retreat->title}} ({{ $registration->retreat->idnumber}})</a></div>
                <div class='col-md-3'><strong>Retreat Dates: </strong>{{ date('F d, Y', strtotime($registration->retreat->start_date))}} - {{ date('F d, Y', strtotime($registration->retreat->end_date))}}</div>
                </div><div class="clearfix"> </div> 
                <div class='row'>
                    <div class='col-md-3'><strong>Registered: </strong>{{ date('F d, Y', strtotime($registration->register_date))}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Registration Confirmed: </strong>
                        @if ($registration->registration_confirm_date == NULL)
                            N/A
                        @else
                            {{date('F d, Y', strtotime($registration->registration_confirm_date))}}
                        @endif
                    </div><div class="clearfix"> </div>
                </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Attendance Confirmed: </strong>
                    @if ($registration->attendance_confirm_date== NULL)
                        N/A
                    @else
                        {{date('F d, Y', strtotime($registration->attendance_confirm_date))}}
                    @endif
                    </div>
                    <div class='col-md-3'><strong>Confirmed by: </strong>{{ $registration->confirmed_by}}</div>
                </div><div class="clearfix"> </div>

                <div class='row'>
                    <div class='col-md-3'><strong>Canceled at: </strong>
                    @if ($registration->canceled_at == NULL)
                        N/A
                    @else
                        {{date('F d, Y', strtotime($registration->canceled_at))}}
                    @endif
                    </div>
                </div><div class="clearfix"> </div>

                <div class='row'>
                    <div class='col-md-3'><strong>Arrived at: </strong>
                    @if (empty($registration->arrived_at))
                        N/A
                    @else
                        {{date('F d, Y', strtotime($registration->arrived_at))}}
                    @endif
                    </div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Departed at: </strong>
                    @if ($registration->departed_at == NULL)
                        N/A
                    @else
                        {{date('F d, Y', strtotime($registration->departed_at))}}
                    @endif
                    </div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-2'><strong>Room: </strong>{{ $registration->room_name}}</div>
                </div><div class="clearfix"> </div>

                <div class='row'>
                    <div class='col-md-6'><strong>Notes: </strong>{{ $registration->notes}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Deposit: </strong>${{ $registration->deposit}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-1'><a href="{{ action('RegistrationsController@edit', $registration->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                    <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['registration.destroy', $registration->id]]) !!}
                    {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                    {!! Form::close() !!}</div><div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </section>
@stop
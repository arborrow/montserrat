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
                    <div class='col-md-3'><strong>Retreatant: </strong><a href="../retreatant/{{ $retreatant->id}}">{{ $retreatant->lastname}},{{ $retreatant->firstname}}</a></div>
                </div><div class="clearfix"> </div>
                         <div class='row'>
                    <div class='col-md-3'><strong>Retreat: </strong><a href="../retreat/{{ $registration->retreat_id}}">{{ $retreat->title}} ({{ $retreat->idnumber}})</a></div>
                <div class='col-md-3'><strong>Retreat Dates: </strong>{{ date('F d, Y', strtotime($registration->start))}} - {{ date('F d, Y', strtotime($registration->end))}}</div>
                </div><div class="clearfix"> </div> 
                <div class='row'>
                    <div class='col-md-3'><strong>Registered: </strong>{{ date('F d, Y', strtotime($registration->register))}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Registration Confirmed: </strong>{{ date('F d, Y', strtotime($registration->confirmregister))}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Attendance Confirmed: </strong>{{ date('F d, Y', strtotime($registration->confirmattend))}}</div>
                    <div class='col-md-3'><strong>Confirmed by: </strong>{{ $registration->confirmedby}}</div>
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
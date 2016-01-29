@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>Retreat Details for #{!! $retreat->idnumber !!}</span>
                <span class="back"><a href={{ action('RetreatsController@index') }}>{!! Html::image('img/retreat.png', 'Retreat Index',array('title'=>"Retreat Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
            </div>
            <div class='row'>
                <div class='col-md-2'><strong>ID#: </strong>{{ $retreat->idnumber}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Starts: </strong>{{date('F d, Y', strtotime($retreat->start))}}</div>
                <div class='col-md-3'><strong>Ends: </strong>{{date('F d, Y', strtotime($retreat->end))}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Title: </strong>{{ $retreat->title}}</div>
                <div class='col-md-3'><strong>Attending: </strong>{{ $retreat->attending}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-6'><strong>Description: </strong>{{ $retreat->description}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Director: </strong>
                    @if ($retreat->directorid == 0)
                        {{$retreat->directorname}}
                    @else
                        <a href="person/{{ $retreat->directorid}}">{{ $retreat->directorname}}</a>
                    @endIf
                </div>
                    
                <div class='col-md-3'><strong>Innkeeper: </strong>
                    @if ($retreat->innkeeperid == 0) 
                        {{$retreat->innkeepername}}
                    @else
                        <a href="person/{{ $retreat->innkeeperid}}">{{ $retreat->innkeepername}}</a>
                    @endIf
                </div>
                <div class='col-md-3'><strong>Assistant: </strong>
                    @if ($retreat->assistantid == 0) 
                        {{$retreat->assistantname}}
                    @else
                        <a href="person/{{ $retreat->assistantid}}">{{ $retreat->assistantname}}</a>
                    @endIf
                </div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Type: </strong>{{ $retreat->type}}</div>
                <div class='col-md-3'><strong>Silent: </strong>{{ $retreat->silent}}</div>
                <div class='col-md-3'><strong>Donation: </strong>{{ $retreat->amount}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-2'><strong>Year: </strong>{{ $retreat->year}}</div>
            </div><div class="clearfix"> </div></div>
            <div class='row'>
                <div class='col-md-1'><a href="{{ action('RetreatsController@edit', $retreat->id) }}" class="btn btn-info">{!! Html::image('img/edit.png', 'Edit',array('title'=>"Edit")) !!}</a></div>
                <div class='col-md-1'>{!! Form::open(['method' => 'DELETE', 'route' => ['retreat.destroy', $retreat->id]]) !!}
                {!! Form::image('img/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!} 
                {!! Form::close() !!}</div><div class="clearfix"> </div>
            </div><br />
        <div class="panel panel-default">  
        <div class="panel-heading">
            <h2>Retreatants Registered</h2>
            <span class="create"><a href={{ action('RegistrationsController@create') }}>{!! Html::image('img/create.png', 'Create Registration',array('title'=>"Create Registration",'class' => 'btn btn-primary')) !!}</a></span>
            <span class="report"><a href={{ action('PagesController@retreatantinforeport',$retreat->idnumber) }}>Retreatant Information Report</a></span>
            <span class="report"><a href={{ action('PagesController@retreatrosterreport',$retreat->idnumber) }}>Retreat Roster</a></span>
            <span class="report"><a href={{ action('PagesController@retreatlistingreport',$retreat->idnumber) }}>Retreat Listing</a></span>
                
        </div>
            @if ($registrations->isEmpty())
                <p> Currently, there are no registrations for this retreats</p>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Date Registered</th>
                        <th>Name</th>
                        <th>Deposit</th>
                        <th>Mobile Phone</th>
                        <th>Parish</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($registrations as $registration)
                    <tr>
                        <td><a href="{{action('RegistrationsController@show', $registration->id)}}">{{ date('F d, Y', strtotime($registration->register)) }}</a></td>
                        <td><a href="{{action('PersonsController@show', $registration->retreatant_id)}}">{{ $registration->retreatantname}}</a></td>
                        <td>{{ $registration->deposit }}</td>
                        <td>{{ $registration->retreatantmobilephone}}</td>
                        <td><a href="{{action('ParishesController@show', $registration->parish_id)}}">{{ $registration->retreatantparish}}</td>
                        <td>{{ $registration->notes }}</td>


                    </tr>
                    @endforeach
            </tbody>
</table>@endif
        </div>
    </div>        </div>

</section>
@stop
@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        {!! Form::open(['url' => 'retreat/room_update', 'method' => 'POST', 'route' => ['retreat.room_update', $retreat->id]]) !!}
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>Retreat #<a href="{{url('retreat/'.$retreat->id)}}">{{ $retreat->idnumber }} - {{ $retreat->title }}</a></span>
                <span class="back"><a href={{ action('RetreatsController@index') }}>{!! Html::image('img/retreat.png', 'Retreat Index',array('title'=>"Retreat Index",'class' => 'btn btn-default')) !!}</a></span></h1>
                <div class='row'>
                    <div class='col-md-3'><strong>Starts: </strong>{{date('F j, Y g:i A', strtotime($retreat->start_date))}}</div>
                    <div class='col-md-3'><strong>Ends: </strong>{{date('F j, Y g:i A', strtotime($retreat->end_date))}}</div>
                    <div class='col-md-3'><strong>Attending: </strong>{{ $retreat->retreatant_count}}</div>
                </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-6'><strong>Description: </strong>{{ $retreat->description}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-1'><strong>Director(s): </strong></div>
                    @if ($retreat->retreatmasters->isEmpty())
                        N/A
                    @else
                    <div class='col-md-2'>
                        @foreach($retreat->retreatmasters as $rm)
                            <a href="{{url('person/'.$rm->id)}}">{{ $rm->display_name }}</a><br /> 
                        @endforeach
                        </div>
                    @endif
    
                <div class='col-md-3'><strong>Innkeeper: </strong>
                    @if ($retreat->innkeeper_id > 0)
                        <a href="{{url('person/'.$retreat->innkeeper_id)}}">{{ $retreat->innkeeper->display_name }}</a>
                    @else
                        N/A
                    @endIf
                </div>
                <div class='col-md-3'><strong>Assistant: </strong>
                    @if ($retreat->assistant_id > 0)
                        <a href="{{url('person/'.$retreat->assistant_id) }}">{{ $retreat->assistant->display_name }}</a>
                    @else
                        N/A
                    @endIf
                </div>

            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-1'><strong>Captain(s): </strong></div>
                    @if ($retreat->captains->isEmpty())
                        N/A
                    @else
                    <div class='col-md-2'>
                        @foreach($retreat->captains as $captain)
                            <a href="/person/{{ $captain->id }}">{{ $captain->display_name }}</a><br /> 
                        @endforeach
                    </div>
                    @endif
            </div>
            <div class='row'>
                <div class='col-md-3'><strong>Type: </strong>{{ $retreat->retreat_type}}</div>
            </div><div class="clearfix"> </div>
                
        </div>
            <hr>
        <div class="panel panel-default">  
        <div class="panel-heading">
            <h2>Registered Retreatants</h2>
            Save Room Assignments {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-default']) !!}

            
        </div>
            @if ($registrations->isEmpty())
                <p> Currently, there are no registrations for this retreats</p>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Date Registered</th>
                        <th>Name</th>
                        <th>Room Preference</th>
                        <th>Room</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($registrations as $registration)
                    <tr>
                        <td class='col-md-2'><a href="{{action('RegistrationsController@show', $registration->id)}}">{{ date('F d, Y', strtotime($registration->register_date)) }}</a></td>
                        <td class='col-md-3'>{!!$registration->retreatant->contact_link!!}</td>
                        <td class='col-md-2'>{{$registration->retreatant->note_room_preference_text}}</td>
                        <td class='col-md-2'>
                            @if($registration->canceled_at === NULL)
                            {!! Form::select('registrations['.$registration->id.']', $rooms, $registration->room_id) !!}
                            @else
                            Canceled
                            @endIf
                        </td>
                        <td class='col-md-3'>    
                            {!! Form::text('notes['.$registration->id.']', $registration->notes) !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
</table>@endif
        </div>
    </div>        </div>

</section>
@stop
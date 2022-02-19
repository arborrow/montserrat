@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        {!! Form::open(['url' => 'retreat/room_update', 'method' => 'POST', 'route' => ['retreat.room_update', $retreat->id]]) !!}

        <div class="panel panel-default">
            <div class="panel-heading">
                <span><h2>Retreat #<a href="{{url('retreat/'.$retreat->id)}}">{{ $retreat->idnumber }} - {{ $retreat->title }}</a></span>
                <span class="back"><a href={{ action([\App\Http\Controllers\RetreatController::class, 'index']) }}>{!! Html::image('images/retreat.png', 'Retreat Index',array('title'=>"Retreat Index",'class' => 'btn btn-outline-dark')) !!}</a></span></h1>
                <div class='row'>
                    <div class='col-md-3'><strong>Starts: </strong>{{date('F j, Y g:i A', strtotime($retreat->start_date))}}</div>
                    <div class='col-md-3'><strong>Ends: </strong>{{date('F j, Y g:i A', strtotime($retreat->end_date))}}</div>
                    <div class='col-md-3'><strong>Attending: </strong>{{ $retreat->retreatant_count}}</div>
                </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-6'><strong>Description: </strong>{{ $retreat->description}}</div>
            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Director(s): </strong></div>
                    @if ($retreat->retreatmasters->isEmpty())
                        N/A
                    @else
                    <div class='col-md-3'>
                        @foreach($retreat->retreatmasters as $retreatmaster)
                            {!! $retreatmaster->contact_link_full_name !!}<br />
                        @endforeach
                        </div>
                    @endif

                <div class='col-md-3'><strong>Innkeeper: </strong>
                    @if ($retreat->innkeepers->isEmpty())
                        N/A
                    @else
                    <div class='col-md-3'>
                        @foreach($retreat->innkeepers as $innkeeper)
                            {!! $innkeeper->contact_link_full_name !!}<br />
                        @endforeach
                        </div>
                    @endif
                </div>
                <div class='col-md-3'><strong>Assistant: </strong>
                    @if ($retreat->assistants->isEmpty())
                        N/A
                    @else
                    <div class='col-md-3'>
                        @foreach($retreat->assistants as $assistant)
                            {!! $assistant->contact_link_full_name !!}<br />
                        @endforeach
                        </div>
                    @endif
                </div>

            </div><div class="clearfix"> </div>
            <div class='row'>
                <div class='col-md-3'><strong>Ambassador(s): </strong></div>
                    @if ($retreat->ambassadors->isEmpty())
                        N/A
                    @else
                    <div class='col-md-3'>
                        @foreach($retreat->ambassadors as $ambassador)
                            {!! $ambassador->contact_link_full_name !!} <br />
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
            Save Room Assignments {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}


        </div>
            @if ($registrations->isEmpty())
                <p> Currently, there are no registrations for this retreats</p>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Registered</th>
                        <th>Room Preference</th>
                        <th>Room</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($registrations->sortBy('retreatant.sort_name') as $registration)
                    <tr>
                        <td class='col-md-3'>{!!$registration->retreatant->contact_link!!}</td>
                        <td class='col-md-2'><a href="{{action([\App\Http\Controllers\RegistrationController::class, 'show'], $registration->id)}}">{{ date('F d, Y', strtotime($registration->register_date)) }}</a></td>
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

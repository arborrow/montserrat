@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <span class="grey">Registration Index</span> 
                        @can('create-registration')
                            <span class="create">
                                <a href={{ action('RegistrationsController@create') }}>{!! Html::image('img/create.png', 'Create a Registration',array('title'=>"Create a Registration",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                        @endCan
                    </h1>
                </div>
                @if ($registrations->isEmpty())
                    <p> Yikes, there are no registrations!</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Registrations for Upcoming Retreats</h2></caption>
                    <thead>
                        <tr>
                            <th>Registered</th> 
                            <th>Retreatant</th> 
                            <th>Retreat</th>
                            <th>Retreat Dates</th>
                            <th>Attendance Confirmed</th> 
                            <th>Room</th>
                            <th>Deposit</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                        <tr>
                            <td><a href="registration/{{$registration->id}}">{{ date('F d, Y h:i A', strtotime($registration->created_at)) }}</a></td>
                            <td>
                                @if (isset($registration->retreatant->display_name))
                                    {!!$registration->retreatant->contact_link_full_name!!}
                                @else
                                    N/A
                                @endif  
                            </td>
                            <td><a href="retreat/{{$registration->event_id}}">{{ $registration->retreat->title }} ({{$registration->retreat->idnumber}})</a></td>
                            <td>{{ date('F d, Y', strtotime($registration->retreat->start_date)) }} - {{ date('F d, Y', strtotime($registration->retreat->end_date)) }}</td>
                            <td>{{ $registration->registration_confirm_date_text }}</td>
                            <td>
                                @if (isset($registration->room->name))
                                    <a href="room/{{$registration->room_id}}">{{ $registration->room->name }}</a>
                                @else
                                    N/A
                                @endif
                                    
                            </td>
                            <td>${{ $registration->deposit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
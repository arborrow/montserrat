@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>
            Registration Index
            @can('create-registration')
                <span class="options">
                    <a href={{ action('RegistrationController@create') }}>{!! Html::image('images/create.png', 'Create a Registration',array('title'=>"Create a Registration",'class' => 'btn btn-light')) !!}</a>
                </span>
            @endCan
        </h1>
    </div>
    <div class="col-lg-12 table-responsive-lg">
        @if ($registrations->isEmpty())
            <div class="col-lg-12 text-center py-5">
                <p>Yikes, there are no registrations!</p>
            </div>
        @else
            <table class="table table-bordered table-striped table-hover">
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
                        <td><a href="registration/{{$registration->id}}">{{ date('F d, Y h:i A', strtotime($registration->register_date)) }}</a></td>
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
@stop

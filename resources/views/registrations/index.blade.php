@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Registration Index</span> 
                    <span class="create"><a href={{ action('RegistrationsController@create') }}>{!! Html::image('img/create.png', 'Create a Registration',array('title'=>"Create a Registration",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if ($registrations->isEmpty())
                    <p> Yikes, there are no registrations!</p>
                @else
                <table class="table"><caption><h2>Registrations</h2></caption>
                    <thead>
                        <tr>
                            <th>Registered</th> 
                            <th>Retreatant</th> 
                            <th>Retreat</th>
                            <th>Retreat Dates</th>
                            <th>Attendance Confirmed</th> 
                            <th>Deposit</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                        <tr>
                            <td><a href="registration/{{$registration->id}}">{{ date('F d, Y', strtotime($registration->register)) }}</a></td>
                            <td><a href="person/{{$registration->retreatant_id}}">{{ $registration->retreatant->lastname}}, {{ $registration->retreatant->firstname}}</a></td>
                            <td><a href="retreat/{{$registration->retreat_id}}">{{ $registration->retreat->title }} ({{$registration->retreat->idnumber}})</a></td>
                            <td>{{ date('F d, Y', strtotime($registration->start)) }} - {{ date('F d, Y', strtotime($registration->end)) }}</td>
                            <td>{{ date('F d, Y', strtotime($registration->confirmattend)) }}</td>
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
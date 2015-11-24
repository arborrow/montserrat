@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Room Index</span> 
                    <span class="create"><a href={{ action('RoomsController@create') }}>{!! Html::image('img/create.png', 'Create a Room',array('title'=>"Create Room",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                @if ($rooms->isEmpty())
                    <p> Yikes, there are no rooms at this retreat house!</p>
                @else
                <table class="table"><caption><h2>Rooms</h2></caption>
                    <thead>
                        <tr>
                            <th>ID#</th>
                            <th>Building</th>
                            <th>Room</th> 
                            <th>Status</th> 
                       </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                        <tr>
                            <td><a href="room/{{$room->id}}">{{$room->id}}</a></td>
                            <td>{{ $room->building_id}}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
@stop
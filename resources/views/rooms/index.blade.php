@extends('template')
@section('content')



    <section class="section-padding">
        <div class="jumbotron text-left">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                    <span class="grey">Room Index</span> 
                        @can('room-create')
                            <span class="create">
                                <a href={{ action('RoomController@create') }}>{!! Html::image('img/create.png', 'Create a Room',array('title'=>"Create Room",'class' => 'btn btn-primary')) !!}</a>
                            </span>
                        @endCan
                    </h1>
                    
                </div>
                @if ($roomsort->isEmpty())
                    <p> Yikes, there are no rooms at this retreat house!</p>
                @else
                <table class="table table-bordered table-striped table-hover"><caption><h2>Rooms</h2></caption>
                    <thead>
                        <tr>
                            <th>Room</th> 
                            <th>Building</th>
                            <th>Status</th> 
                       </tr>
                    </thead>
                    <tbody>
                        @foreach($roomsort as $room)
                        <tr>
                            <td><a href="room/{{$room->id}}">{{ $room->name }}</a></td>
                            <td>{{ $room->building}}</td>
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
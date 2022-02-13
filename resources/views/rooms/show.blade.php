@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <div class="panel panel-default">
            <div class="panel-heading">
                    <span>
                        <h2>
                            @can('update-room')
                                <a href="{{url('room/'.$room->id.'/edit')}}">{{ $room->building }} - Room #{!! $room->name !!}</a>
                            @else
                                {{ $room->building }} - Room #{{$room->name}}
                            @endCan
                        </h2>
                    </span>
                    <span class="back"><a href={{ action([\App\Http\Controllers\RoomController::class, 'index']) }}>{!! Html::image('images/room.png', 'Room Index',array('title'=>"Room Index",'class' => 'btn btn-primary')) !!}</a></span></h1>
                </div>
                <div class='row'>
                    <div class='col-md-2'><strong>Building: </strong>{{ $room->building}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Name: </strong>{{ $room->name}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Description: </strong>{{ $room->description}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-6'><strong>Notes: </strong>{{ $room->notes}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    <div class='col-md-3'><strong>Floor: </strong>{{ $room->floor}}</div>
                    <div class='col-md-3'><strong>Access: </strong>{{ $room->access}}</div>
                    <div class='col-md-3'><strong>Type: </strong>{{ $room->type}}</div>
                    <div class='col-md-3'><strong>Occupancy: </strong>{{ $room->occupancy}}</div>
                    <div class='col-md-3'><strong>Status: </strong>{{ $room->status}}</div>
                </div><div class="clearfix"> </div>
                <div class='row'>
                    @can('update-room')
                        <div class='col-md-1'>
                            <a href="{{ action([\App\Http\Controllers\RoomController::class, 'edit'], $room->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                        </div>
                    @endCan
                    @can('delete-room')
                        <div class='col-md-1'>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['room.destroy', $room->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                            {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                            {!! Form::close() !!}
                        </div>
                    @endCan
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </section>
@stop

@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Room {!! $room->id !!}</h1>
    {!! Form::open(['method' => 'PUT', 'route' => ['room.update', $room->id]]) !!}
    {!! Form::hidden('id', $room->id) !!}
    <div class="form-group">
        {!! Form::label('location_id', 'Building ID:', ['class' => 'col-md-1'])  !!}
        {!! Form::select('location_id', $locations, $room->location_id, ['class' => 'col-md-2']) !!}
    </div><div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'col-md-1']) !!}
        {!! Form::text('name', $room->name, ['class' => 'col-md-2']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('description', 'Description:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('description', $room->description, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
        {!! Form::textarea('notes', $room->notes, ['class' => 'col-md-5', 'rows'=>'3']) !!}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::label('floor', 'Floor:', ['class' => 'col-md-1'])  !!}
        {!! Form::select('floor', $floors, $room->floor, ['class' => 'col-md-2']) !!}

        {!! Form::label('access', 'Access:', ['class' => 'col-md-1']) !!}
        {!! Form::text('access', $room->access, ['class' => 'col-md-1']) !!}

        {!! Form::label('type', 'Type:', ['class' => 'col-md-1']) !!}
        {!! Form::text('type', $room->type, ['class' => 'col-md-1']) !!}

        {!! Form::label('occupancy', 'Occupancy:', ['class' => 'col-md-1']) !!}
        {!! Form::text('occupancy', $room->occupancy, ['class' => 'col-md-1']) !!}

        {!! Form::label('status', 'Status:', ['class' => 'col-md-1']) !!}
        {!! Form::text('status', $room->status, ['class' => 'col-md-1']) !!}
    </div>
    <div class="clearfix"> </div>

    <div class="form-group">
        {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop

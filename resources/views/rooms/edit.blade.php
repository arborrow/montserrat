@extends('template')
@section('content')

<div class="jumbotron text-left">
    <h1>Edit Room {!! $room->id !!}</h1>
    {{ html()->form('PUT', route('room.update', [$room->id]))->open() }}
    {{ html()->hidden('id', $room->id) }}
    <div class="form-group">
        {{ html()->label('Building ID:', 'location_id')->class('col-md-1') }}
        {{ html()->select('location_id', $locations, $room->location_id)->class('col-md-2') }}
    </div><div class="clearfix"> </div>

    <div class="form-group">
        {{ html()->label('Name:', 'name')->class('col-md-1') }}
        {{ html()->text('name', $room->name)->class('col-md-2') }}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {{ html()->label('Description:', 'description')->class('col-md-1') }}
        {{ html()->textarea('description', $room->description)->class('col-md-5')->rows('3') }}
    </div>
    <div class="form-group">
        {{ html()->label('Notes:', 'notes')->class('col-md-1') }}
        {{ html()->textarea('notes', $room->notes)->class('col-md-5')->rows('3') }}
    </div>
    <div class="clearfix"> </div>
    <div class="form-group">
        {{ html()->label('Floor:', 'floor')->class('col-md-1') }}
        {{ html()->select('floor', $floors, $room->floor)->class('col-md-2') }}

        {{ html()->label('Access:', 'access')->class('col-md-1') }}
        {{ html()->text('access', $room->access)->class('col-md-1') }}

        {{ html()->label('Type:', 'type')->class('col-md-1') }}
        {{ html()->text('type', $room->type)->class('col-md-1') }}

        {{ html()->label('Occupancy:', 'occupancy')->class('col-md-1') }}
        {{ html()->text('occupancy', $room->occupancy)->class('col-md-1') }}

        {{ html()->label('Status:', 'status')->class('col-md-1') }}
        {{ html()->text('status', $room->status)->class('col-md-1') }}
    </div>
    <div class="clearfix"> </div>

    <div class="form-group">
        {{ html()->input('image', 'btnSave')->class('btn btn-primary')->attribute('src', asset('images/save.png')) }}
    </div>
    {{ html()->form()->close() }}
</div>
@stop

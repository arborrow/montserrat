@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-12">
        <h1>Edit: {!! $location->name !!}</h1>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <h2>Location</h2>
            </div>
            <div class="col-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['location.update', $location->id]]) !!}
                {!! Form::hidden('id', $location->id) !!}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', $location->name , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('label', 'Label') !!}
                                        {!! Form::text('label', $location->label , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('type', 'Type') !!}
                                        {!! Form::select('type', $location_types, $location->type, ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        {!! Form::label('description', 'Description') !!}
                                        {!! Form::textarea('description', $location->description, ['class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('latitude', 'Latitude') !!}
                                        {!! Form::text('latitude', number_format($location->latitude,8) , ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('longitude', 'Longitude') !!}
                                        {!! Form::text('longitude', number_format($location->longitude,8) , ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('occupancy', 'Occupancy') !!}
                                        {!! Form::text('occupancy', $location->occupancy, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('room_id', 'Room') !!}
                                        {!! Form::select('room_id', $rooms, $location->room_id, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-md-4">
                                        {!! Form::label('parent_id', 'Parent') !!}
                                        {!! Form::select('parent_id', $parents, $location->parent_id, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        {!! Form::label('notes', 'Notes') !!}
                                        {!! Form::textarea('notes', $location->notes, ['class' => 'form-control', 'rows' => 3]) !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop

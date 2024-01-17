@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $location->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Location</h2>
            </div>
            <div class="col-lg-12">
                {{ html()->form('PUT', route('location.update', [$location->id]))->open() }}
                {{ html()->hidden('id', $location->id) }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Name', 'name') }}
                                        {{ html()->text('name', $location->name)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Label', 'label') }}
                                        {{ html()->text('label', $location->label)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Type', 'type') }}
                                        {{ html()->select('type', $location_types, $location->type)->class('form-control') }}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ html()->label('Description', 'description') }}
                                        {{ html()->textarea('description', $location->description)->class('form-control')->rows(3) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Latitude', 'latitude') }}
                                        {{ html()->text('latitude', number_format($location->latitude, 8))->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Longitude', 'longitude') }}
                                        {{ html()->text('longitude', number_format($location->longitude, 8))->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Occupancy', 'occupancy') }}
                                        {{ html()->text('occupancy', $location->occupancy)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Room', 'room_id') }}
                                        {{ html()->select('room_id', $rooms, $location->room_id)->class('form-control') }}
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        {{ html()->label('Parent', 'parent_id') }}
                                        {{ html()->select('parent_id', $parents, $location->parent_id)->class('form-control') }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        {{ html()->label('Notes', 'notes') }}
                                        {{ html()->textarea('notes', $location->notes)->class('form-control')->rows(3) }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            {{ html()->input('image', 'btnSave')->class('btn btn-outline-dark')->attribute('src', asset('images/save.png')) }}
                        </div>
                    </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</div>
@stop

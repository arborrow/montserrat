@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Add A Room</strong></h2>
        {{ html()->form('POST', 'room')->class('form-horizontal panel')->open() }}
        <div class="form-group">

            {{ html()->label('Location:', 'location_id')->class('col-md-1') }}
            {{ html()->select('location_id', $locations, 0)->class('col-md-2') }}

        </div>
        <div class="clearfix"> </div>
        <div class="form-group">
            {{ html()->label('Name:', 'name')->class('col-md-1') }}
            {{ html()->text('name')->class('col-md-2') }}
        </div>
        <div class="clearfix"> </div>
        <div class="form-group">
            {{ html()->label('Description:', 'description')->class('col-md-1') }}
            {{ html()->textarea('description')->class('col-md-5')->rows('3') }}
        </div>
        <div class="clearfix"> </div>
        <div class="form-group">
            {{ html()->label('Notes:', 'notes')->class('col-md-1') }}
            {{ html()->textarea('notes')->class('col-md-5')->rows('3') }}
        </div>
        <div class="clearfix"> </div>
        <div class="form-group">
            {{ html()->label('Floor:', 'floor')->class('col-md-1') }}
            {{ html()->select('floor', $floors, 0)->class('col-md-2') }}
            {{ html()->label('Access:', 'access')->class('col-md-1') }}
            {{ html()->text('access')->class('col-md-2') }}
            {{ html()->label('Type:', 'type')->class('col-md-1') }}
            {{ html()->text('type')->class('col-md-2') }}
            {{ html()->label('Occupancy:', 'occupancy')->class('col-md-1') }}
            {{ html()->text('occupancy', 1)->class('col-md-1') }}
            {{ html()->label('Status:', 'status')->class('col-md-1') }}
            {{ html()->text('status')->class('col-md-1') }}
        </div>
        <div class="clearfix"> </div>

        <div class="col-md-1">
            <div class="form-group">
                {{ html()->submit('Add Room')->class('btn btn-primary') }}
            </div>
        </div>
        <div class="clearfix"> </div>
        {{ html()->form()->close() }}
    </div>
</section>

@stop

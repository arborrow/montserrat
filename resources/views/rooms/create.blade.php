@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Add A Room</strong></h2>
        {!! Form::open(['url' => 'room', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <div class="form-group">

            {!! Form::label('location_id', 'Location:', ['class' => 'col-md-1']) !!}
            {!! Form::select('location_id', $locations, 0, ['class' => 'col-md-2']) !!}

        </div>
        <div class="clearfix"> </div>
        <div class="form-group">
            {!! Form::label('name', 'Name:', ['class' => 'col-md-1']) !!}
            {!! Form::text('name', null, ['class'=>'col-md-2']) !!}
        </div>
        <div class="clearfix"> </div>
        <div class="form-group">
            {!! Form::label('description', 'Description:', ['class' => 'col-md-1']) !!}
            {!! Form::textarea('description', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
        </div>
        <div class="clearfix"> </div>
        <div class="form-group">
            {!! Form::label('notes', 'Notes:', ['class' => 'col-md-1']) !!}
            {!! Form::textarea('notes', null, ['class'=>'col-md-5', 'rows'=>'3']) !!}
        </div>
        <div class="clearfix"> </div>
        <div class="form-group">
            {!! Form::label('floor', 'Floor:', ['class' => 'col-md-1']) !!}
            {!! Form::select('floor', $floors, 0, ['class' => 'col-md-2']) !!}
            {!! Form::label('access', 'Access:', ['class' => 'col-md-1']) !!}
            {!! Form::text('access', null, ['class'=>'col-md-2']) !!}
            {!! Form::label('type', 'Type:', ['class' => 'col-md-1']) !!}
            {!! Form::text('type', null, ['class'=>'col-md-2']) !!}
            {!! Form::label('occupancy', 'Occupancy:', ['class' => 'col-md-1']) !!}
            {!! Form::text('occupancy', 1, ['class' => 'col-md-1']) !!}
            {!! Form::label('status', 'Status:', ['class' => 'col-md-1']) !!}
            {!! Form::text('status', null, ['class'=>'col-md-1']) !!}
        </div>
        <div class="clearfix"> </div>

        <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Room', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
        <div class="clearfix"> </div>
        {!! Form::close() !!}
    </div>
</section>

@stop

@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h2>Create Retreat</h2>
    </div>
    <div class="col-12">
        {!! Form::open(['url' => 'retreat', 'method' => 'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        {!! Form::label('idnumber', 'ID#:') !!}
                        {!! Form::text('idnumber', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-4">
                        {!! Form::label('title', 'Title: ') !!}
                        {!! Form::text('title', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        {!! Form::label('start_date', 'Starts: ') !!}
                        {!! Form::text('start_date', null, ['id' => 'start_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                    </div>
                    <div class="col-4">
                        {!! Form::label('end_date', 'Ends: ') !!}
                        {!! Form::text('end_date', null, ['id' => 'end_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        {!! Form::label('description', 'Description:') !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        {!! Form::label('directors', 'Director(s):') !!}
                        {!! Form::select('directors[]', $d, 0, ['id'=>'directors','class' => 'form-control select2','multiple' => 'multiple']) !!}
                    </div>
                    <div class="col-4">
                        {!! Form::label('captains', 'Ambassador(s):') !!}
                        {!! Form::select('captains[]', $c, 0, ['id'=>'captains','class' => 'form-control select2','multiple' => 'multiple']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        {!! Form::label('innkeeper_id', 'Innkeeper:') !!}
                        {!! Form::select('innkeeper_id', $i, 0, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-3">
                        {!! Form::label('assistant_id', 'Assistant:') !!}
                        {!! Form::select('assistant_id', $a, 0, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-3">
                        {!! Form::label('event_type', 'Type:') !!}
                        {!! Form::select('event_type', $event_types, config('polanco.event_type.ignatian'), ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mt-5">
                    {!! Form::submit('Add Retreat', ['class'=>'btn btn-light']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

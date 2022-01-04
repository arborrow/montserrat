@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h2>Create Retreat</h2>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url' => 'retreat', 'method' => 'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3">
                        {!! Form::label('idnumber', 'ID#:') !!}
                        {!! Form::text('idnumber', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('title', 'Title: ') !!}
                        {!! Form::text('title', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('event_type', 'Type:') !!}
                        {!! Form::select('event_type', $event_types, config('polanco.event_type.ignatian'), ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        {!! Form::label('start_date', 'Starts: ') !!}
                        {!! Form::text('start_date', null, ['id' => 'start_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('end_date', 'Ends: ') !!}
                        {!! Form::text('end_date', null, ['id' => 'end_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('is_active', 'Canceled?:')  !!}
                        {!! Form::select('is_active', $is_active, 1, ['class' => 'form-control']) !!}
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-9">
                        {!! Form::label('description', 'Description:') !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control', 'rows'=>'3']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        {!! Form::label('directors', 'Director(s):') !!}
                        {!! Form::select('directors[]', $d, 0, ['id'=>'directors','class' => 'form-control select2','multiple' => 'multiple']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('innkeeper_ids', 'Innkeeper(s):') !!}
                        {!! Form::select('innkeepers[]', $i, 0, ['id'=>'innkeepers','class' => 'form-control select2','multiple' => 'multiple']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('assistant_ids', 'Assistant(s):') !!}
                        {!! Form::select('assistants[]', $a, 0, ['id'=>'assistants','class' => 'form-control select2','multiple' => 'multiple']) !!}
                    </div>
                    <div class="col-lg-3">
                        {!! Form::label('ambassadors', 'Ambassador(s):') !!}
                        {!! Form::select('ambassadors[]', $c, 0, ['id'=>'ambassadors','class' => 'form-control select2','multiple' => 'multiple']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 mt-5">
                    {!! Form::submit('Add Retreat', ['class'=>'btn btn-light']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

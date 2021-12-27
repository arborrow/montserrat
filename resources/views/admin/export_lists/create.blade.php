@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create export list</h1>
    </div>

    <div class="col-lg-12">
        {!! Form::open(['url'=>'admin/export_list', 'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        {!! Form::label('title', 'Title') !!}
                        {!! Form::text('title', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-4">
                        {!! Form::label('label', 'Label') !!}
                        {!! Form::text('label', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-4">
                        {!! Form::label('type', 'Type') !!}
                        {!! Form::select('type', $export_list_types, NULL, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {!! Form::label('start_date', 'Starts: ') !!}
                        {!! Form::text('start_date', null, ['id' => 'start_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                    </div>
                    <div class="col-lg-4">
                        {!! Form::label('end_date', 'Ends: ') !!}
                        {!! Form::text('end_date', null, ['id' => 'end_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {!! Form::label('last_run_date', 'Last run: ') !!}
                        {!! Form::text('last_run_date', null, ['id' => 'last_run_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                    </div>
                    <div class="col-lg-4">
                        {!! Form::label('next_scheduled_date', 'Next scheduled: ') !!}
                        {!! Form::text('next_scheduled_date', null, ['id' => 'next_scheduled_date', 'class' => 'form-control flatpickr-date-time bg-white']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('fields', 'Fields') !!}
                        {!! Form::textarea('fields', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('filters', 'Filters') !!}
                        {!! Form::textarea('filters', NULL , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::submit('Add export list', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

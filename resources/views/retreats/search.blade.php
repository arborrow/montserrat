@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Events</strong></h1>
        </div>

        {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal', 'route' => ['retreats.results']]) !!}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{!! Form::image('images/submit.png','btnSave',['class' => 'btn btn-outline-dark pull-right']) !!}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::label('begin_date', 'Begin Date:', ['class' => 'control-label col-sm-3']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('begin_date', NULL, ['class'=>'form-control flatpickr-date']) !!}
                    </div>

                    {!! Form::label('end_date', 'End Date:', ['class' => 'control-label col-sm-3']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('end_date', NULL, ['class'=>'form-control flatpickr-date']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('title', 'Title:', ['class' => 'control-label col-sm-3'])  !!}
                        <div class="col-sm-8">
                            {!! Form::text('title', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('idnumber', 'ID number:', ['class' => 'control-label col-sm-3'])  !!}
                        <div class="col-sm-8">
                            {!! Form::text('idnumber', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('event_type_id', 'Event type:', ['class' => 'control-label col-sm-3'])  !!}
                        <div class="col-sm-8">
                        {!! Form::select('event_type_id', $event_types, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>


@stop

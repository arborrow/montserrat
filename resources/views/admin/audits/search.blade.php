@extends('template')
@section('content')

<div class="jumbotron text-left">
    <div class="panel panel-default">

        <div class='panel-heading'>
            <h1><strong>Search Audit Logs</strong></h1>
        </div>

        {!! Form::open(['method' => 'GET', 'class' => 'form-horizontal', 'route' => ['audits.results']]) !!}

        <div class="panel-body">
            <div class='panel-heading'>
                <h2>
                    <span>{!! Form::image('images/submit.png','btnSave',['class' => 'btn btn-outline-dark pull-right']) !!}</span>
                </h2>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <h3 class="text-primary">Audit information</h3>
                    <div class="row">
                        <div class="col-lg-1">
                            {!! Form::label('created_at_operator', 'Comp.')  !!}
                            {!! Form::select('created_at_operator', config('polanco.operators'), '=', ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('created_at', 'Created:')  !!}
                            {!! Form::date('created_at', NULL, ['class'=>'form-control flatpickr-date-time']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('user_id', 'User')  !!}
                            {!! Form::select('user_id', $users, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('auditable_type', 'Model:')  !!}
                            {!! Form::select('auditable_type', $models, NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-3">
                            {!! Form::label('auditable_id', 'ID#:')  !!}
                            {!! Form::number('auditable_id', NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('event', 'Action:')  !!}
                            {!! Form::select('event', $actions, NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('old_values', 'Old value:')  !!}
                            {!! Form::text('old_values', NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('new_values', 'New value:')  !!}
                            {!! Form::text('new_values', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            {!! Form::label('url', 'URL:')  !!}
                            {!! Form::text('url', NULL, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-lg-4">
                            {!! Form::label('tags', 'Tags:')  !!}
                            {!! Form::text('tags', NULL, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@stop

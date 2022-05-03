@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create SquareSpace Custom Form Field</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url'=>'admin/squarespace/custom_form/' . $custom_form->id . '/store', 'method'=>'post']) !!}
        {!! Form::hidden('id', $custom_form->id) !!}
            <div class="form-group">
                <h2>Custom Form: {{ $custom_form->name }}</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('type', 'Type') !!}
                        {!! Form::text('type', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('sort_order', 'Sort order') !!}
                        {!! Form::text('sort_order', NULL , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::submit('Add Custom Form', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop

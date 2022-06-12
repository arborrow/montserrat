@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create SquareSpace Custom Form</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url'=>'admin/squarespace/custom_form/', 'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', NULL , ['class' => 'form-control']) !!}
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

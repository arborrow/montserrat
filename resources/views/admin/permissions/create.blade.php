@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-12">
        <h1>Create Permission</h1>
    </div>
    <div class="col-12">
        {!! Form::open(['url' => 'admin/permission', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-md-4">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-12 col-md-4">
                        {!! Form::label('display_name', 'Display Name') !!}
                        {!! Form::text('display_name', NULL , ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {!! Form::label('description', 'Description')  !!}
                        {!! Form::textarea('description', NULL, ['class' => 'form-control', 'rows' => 3]) !!} 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    {!! Form::submit('Add Permission', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
@extends('template')
@section('content')

<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Create Role</h1>
    </div>
    <div class="col-lg-12">
        {!! Form::open(['url'=>'admin/role', 'method'=>'post']) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', NULL , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('display_name', 'Display Name')  !!}
                        {!! Form::text('display_name', NULL , ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {!! Form::label('description', 'Description') !!}
                        {!! Form::textarea('description', NULL, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::submit('Add Role', ['class'=>'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $permission->name !!}</h1>
    </div>
    <div class="col-lg-12">
        <h2>Permission details</h2>
        {!! Form::open(['method' => 'PUT', 'route' => ['permission.update', $permission->id]]) !!}
        {!! Form::hidden('id', $permission->id) !!}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('name', 'Name')  !!}
                        {!! Form::text('name', $permission->name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('display_name', 'Display name')  !!}
                        {!! Form::text('display_name', $permission->display_name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-lg-12 col-md-4">
                        {!! Form::label('description', 'Description')  !!}
                        {!! Form::text('description', $permission->description, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
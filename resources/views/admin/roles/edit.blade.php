@extends('template')
@section('content')
<div class="row bg-cover">
    <div class="col-lg-12">
        <h1>Edit: {!! $role->name !!}</h1>    
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h2>Permission Details</h2>    
            </div>
            <div class="col-lg-12">
                {!! Form::open(['method' => 'PUT', 'route' => ['role.update', $role->id]]) !!}
                {!! Form::hidden('id', $role->id) !!}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12 col-md-4">
                                        {!! Form::label('name', 'Name')  !!}
                                        {!! Form::text('name', $role->name, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-12 col-md-4">
                                        {!! Form::label('display_name', 'Display name')  !!}
                                        {!! Form::text('display_name', $role->display_name, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-lg-12 col-md-4">
                                        {!! Form::label('description', 'Description')  !!}
                                        {!! Form::text('description', $role->description, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            {!! Form::image('images/save.png','btnSave',['class' => 'btn btn-outline-dark']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}  
            </div>
        </div>    
    </div>  
</div>
@stop
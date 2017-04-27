@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Permission:</strong></h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['permission.update', $permission->id]]) !!}
    {!! Form::hidden('id', $permission->id) !!}
    
        <span>
            <h2>Permission details</h2>
                <div class="form-group">
                    <div class='row'>
                        {!! Form::label('name', 'Name:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('name', $permission->name, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('display_name', 'Display name:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('display_name', $permission->display_name, ['class' => 'col-md-3']) !!}
                    </div>
                    <div class='row'>
                        {!! Form::label('description', 'Description:', ['class' => 'col-md-3'])  !!}
                        {!! Form::text('description', $permission->description, ['class' => 'col-md-3']) !!}
                    </div>
                </div>
            </span>
                

    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop
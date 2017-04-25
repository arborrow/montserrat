@extends('template')
@section('content')
    

<div class="jumbotron text-left">
    <span><h2><strong>Edit Group:</strong></h2></span>

    {!! Form::open(['method' => 'PUT', 'route' => ['group.update', $group->id]]) !!}
    {!! Form::hidden('id', $group->id) !!}
    
        <span><h2>Group details</h2>
            <div class="form-group">
                <div class='row'>
                    {!! Form::label('name', 'Name:', ['class' => 'col-md-3'])  !!}

                    {!! Form::text('name', $group->name, ['class' => 'col-md-3']) !!}
                </div>
                <div class='row'>
                    {!! Form::label('title', 'Title:', ['class' => 'col-md-3'])  !!}

                    {!! Form::text('title', $group->title, ['class' => 'col-md-3']) !!}
                </div>
                <div class='row'>
                    {!! Form::label('description', 'Description:', ['class' => 'col-md-3'])  !!}
                    {!! Form::textarea('description', $group->description, ['class' => 'col-md-3']) !!}                   
                </div>             
                <div class="form-group">
                    {!! Form::label('is_active', 'Active:', ['class' => 'col-md-1'])  !!}
                    {!! Form::checkbox('is_active', 1, $group->is_active, ['class' => 'col-md-1']) !!}
                    {!! Form::label('is_hidden', 'Hidden:', ['class' => 'col-md-1'])  !!}
                    {!! Form::checkbox('is_hidden', 1, $group->is_hidden, ['class' => 'col-md-1']) !!}
                    {!! Form::label('is_reserved', 'Reserved:', ['class' => 'col-md-1'])  !!}
                    {!! Form::checkbox('is_reserved', 1, $group->is_reserved, ['class' => 'col-md-1']) !!}
                </div>
                <div class="clearfix"> </div>
    
            </div>
        </span>
                
    <div class="clearfix"> </div>
    <div class="form-group">
        {!! Form::image('img/save.png','btnSave',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
@stop
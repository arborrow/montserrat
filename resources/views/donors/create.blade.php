@extends('template')
@section('content')

<section class="section-padding">
    <div class="jumbotron text-left">
        <h2><strong>Create Group</strong></h2>
        {!! Form::open(['url' => 'group', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
        <span>
            <div class='row'>
                {!! Form::label('name', 'Name:', ['class' => 'col-md-3'])  !!}

                {!! Form::text('name', null, ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('title', 'Title:', ['class' => 'col-md-3'])  !!}

                {!! Form::text('title', null, ['class' => 'col-md-3']) !!}
            </div>
            <div class='row'>
                {!! Form::label('description', 'Description:', ['class' => 'col-md-3'])  !!}
                {!! Form::textarea('description', NULL, ['class' => 'col-md-3']) !!}                   
            </div>             
            <div class="form-group">
                {!! Form::label('is_active', 'Active:', ['class' => 'col-md-1'])  !!}
                {!! Form::checkbox('is_active', 1, false,['class' => 'col-md-1']) !!}
                {!! Form::label('is_hidden', 'Hidden:', ['class' => 'col-md-1'])  !!}
                {!! Form::checkbox('is_hidden', 0, false,['class' => 'col-md-1']) !!}
                {!! Form::label('is_reserved', 'Reserved:', ['class' => 'col-md-1'])  !!}
                {!! Form::checkbox('is_reserved', 0, false,['class' => 'col-md-1']) !!}
            </div>
                    
        <div class="clearfix"> </div>
     <div class="col-md-1">
            <div class="form-group">
                {!! Form::submit('Add Group', ['class'=>'btn btn-primary']) !!}
            </div>
                {!! Form::close() !!}
        </div>
        <div class="clearfix"> </div>
    </span>
    </div>
</section>
@stop